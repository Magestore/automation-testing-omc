<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 4:37 PM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposEditCustomerCheckAddAddressButtonCC38Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon
 * 3. Select a customer in list"
 *
 * Steps:
 * "1. Click to edit the selected customer
 * 2. Click on [Add address] button > add an address successfully
 * 3.  On [Edit customer] popup, select that address for shipping and Billing address
 * 4. Save"
 *
 * Acceptance:
 * 4. That address will be used to checkout order
 *
 */
class WebposEditCustomerCheckAddAddressButtonCC38Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(WebposIndex $webposIndex, FixtureFactory $factory)
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $factory;
    }

    public function test(Address $address, $products)
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Create Customer
        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Select an existing customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();

        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getEmail());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-change-customer"]');
        sleep(1);
        $this->webposIndex->getCheckoutCartHeader()->getIconEditCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        $this->webposIndex->getCheckoutEditCustomer()->getAddAddressButton()->click();
        sleep(1);
        $this->assertTrue(
            $this->webposIndex->getCheckoutEditAddress()->isVisible(),
            'Add address popup is not visible.'
        );
        //fill address data
        $this->webposIndex->getCheckoutEditAddress()->waingPageLoading();
        sleep(3);
        $this->webposIndex->getCheckoutEditAddress()->setFiledAdress($address->getData());
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        $this->webposIndex->getCheckoutEditAddress()->waitForElementNotVisible('[id="customer-overlay"]');
        sleep(1);
        $this->webposIndex->getCheckoutEditCustomer()->getShippingAddressItem('John Doe, Culver City, US, California, 555-55-555-55')->click();
        $this->webposIndex->getCheckoutEditCustomer()->getBillingAddressItem('John Doe, Culver City, US, California, 555-55-555-55')->click();
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="form-edit-customer"]');
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
        $customerAddress = $address->getData();
        $shippingAddress = [];
        $shippingAddress['name'] = $customerAddress['firstname'] . ' ' . $customerAddress['lastname'];
        $shippingAddress['address'] = $customerAddress['city'] . ', '
            . $customerAddress['region'] . ', '
            . $customerAddress['postcode'] . ', '
            . 'US';
        $shippingAddress['telephone'] = $customerAddress['telephone'];
        $billingAddress = $shippingAddress;

        return [
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress
        ];

    }
}