<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 2:08 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\BillingShippingAddress;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckoutByCustomerOH10Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\BillingShippingAddress
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Add some product to cart
 * 3. Select an exist customer whose billing address and shipping address are the same
 * 4. Click on [Checkout] button
 * Steps:
 * 1. Place order successfully
 * 2. Go to [Orders history] menu
 * Acceptance Criteria:
 * That customer information will be shown on Billing address  and Shipping address section
 */
class WebposCheckoutByCustomerOH10Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @param $products
     * @return array
     */
    public function test(FixtureFactory $fixtureFactory, $products)
    {
        // Create Customer shipping address and billing address are the same
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'johndoe_MI']);
        $customer->persist();
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        // change customer
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        // Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Select payment
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Place Order
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        $customerAddress = $customer->getAddress();
        $shippingAddress = [];
        $shippingAddress['name'] = $customerAddress[0]['firstname'] . ' ' . $customerAddress[0]['lastname'];
        $shippingAddress['address'] = $customerAddress[0]['city'] . ', '
            . $customerAddress[0]['region'] . ', '
            . $customerAddress[0]['postcode'] . ', '
            . 'US';
        $shippingAddress['telephone'] = $customerAddress[0]['telephone'];
        $billingAddress = $shippingAddress;
        return [
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress
        ];

    }
}
