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
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckoutByGuestOH09Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\BillingShippingAddress
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Add some product to cart
 * 3. Click on [Checkout] button
 * Steps:
 * 1. Place order successfully
 * 2. Go to [Orders history] menu
 * Acceptance Criteria:
 * Guest information will be shown on Billing address  and Shipping address section
 */
class WebposCheckoutByGuestOH09Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @param $products
     * @param $configData
     * @return array
     */
    public function test(FixtureFactory $fixtureFactory, $products, $configData)
    {
        // Config Guest checkout
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();
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
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        sleep(1);
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Go to Order History
        sleep(1);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $configData = $fixtureFactory->createByCode('configData', ['dataset' => $configData]);
        $section = $configData->getSection();
        $shippingAddress = [];
        $shippingAddress['name'] = $section['webpos/guest_checkout/first_name']['value'] . ' '
            . $section['webpos/guest_checkout/last_name']['value'];
        $shippingAddress['address'] = $section['webpos/guest_checkout/city']['value'] . ', '
            . $section['webpos/guest_checkout/region_id']['label'] . ', '
            . $section['webpos/guest_checkout/zip']['value'] . ', '
            . $section['webpos/guest_checkout/country_id']['value'];
        $shippingAddress['telephone'] = $section['webpos/guest_checkout/telephone']['value'];
        $billingAddress = $shippingAddress;
        return [
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress
        ];

    }
}
