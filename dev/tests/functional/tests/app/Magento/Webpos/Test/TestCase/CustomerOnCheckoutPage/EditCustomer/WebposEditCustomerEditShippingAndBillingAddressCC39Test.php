<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/27/2018
 * Time: 8:26 AM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposEditCustomerEditShippingAndBillingAddressCC39Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon
 * 3. Select a customer in list"
 *
 * Steps:
 * "1. Click to edit the selected customer
 * 2. Edit Shipping and Billing address
 * 3. Save"
 *
 * Acceptance:
 * "3.
 * - Billing address and shipping address will be updated successfully
 * - That addresses will be used to checkout order"
 *
 */
class WebposEditCustomerEditShippingAndBillingAddressCC39Test extends Injectable
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
        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI_ship_CA_bill']);
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
        //Edit customer
        $this->webposIndex->getCheckoutCartHeader()->getIconEditCustomer()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        //Edit shipping address
        $this->webposIndex->getCheckoutEditCustomer()->getEditShippingAddressIcon()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-customer-add-address-checkout"]');
        sleep(3);
        $this->webposIndex->getCheckoutEditAddress()->setFiledAdress($address->getData());
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        $this->webposIndex->getCheckoutEditAddress()->waitForElementNotVisible('[id="customer-overlay"]');
        sleep(3);
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        $this->assertEquals(
            '6161 West Centinela Avenue , Culver City , California , US 90230',
            $this->webposIndex->getCheckoutEditCustomer()->getShippingAddress()->getText(),
            'Shipping address is not change.'
        );
        //Edit billing address
        $this->webposIndex->getCheckoutEditCustomer()->getEditBillingAddressIcon()->click();
        sleep(3);
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-customer-add-address-checkout"]');
        $this->webposIndex->getCheckoutEditAddress()->setFiledAdress($address->getData());
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        $this->webposIndex->getCheckoutEditAddress()->waitForElementNotVisible('[id="customer-overlay"]');
        sleep(3);
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="form-edit-customer"]');
        $this->assertEquals(
            '6161 West Centinela Avenue , Culver City , California , US 90230',
            $this->webposIndex->getCheckoutEditCustomer()->getBillingAddress()->getText(),
            'Billing address is not change.'
        );
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="form-edit-customer"]');
        $this->webposIndex->getMsWebpos()->waitForElementVisible('#toaster');
        $this->assertEquals(
            'The customer is saved successfully.',
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'Customer success save message is wrong'
        );
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
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
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