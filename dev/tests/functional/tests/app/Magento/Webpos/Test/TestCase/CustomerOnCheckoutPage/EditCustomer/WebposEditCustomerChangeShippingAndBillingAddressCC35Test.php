<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 1:15 PM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\EditCustomer;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposEditCustomerChangeShippingAndBillingAddressCC35Test extends Injectable
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

    public function test($products)
    {
        // Create Customer
        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_multiple_addresses']);
        $customer->persist();
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Login webpos
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
        $shippingAddress = "John Doe, Culver City, US, California, 555-55-555-55";
        $billingAddress = "Billy Holiday, New York, US, New York, 777-77-77-77";
        $this->webposIndex->getCheckoutEditCustomer()->getShippingAddressList()->setValue($shippingAddress);
        $this->webposIndex->getCheckoutEditCustomer()->getBillingAddressList()->setValue($billingAddress);
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="form-edit-customer"]');
        $this->webposIndex->getMsWebpos()->waitForElementVisible('#toaster');
        $this->assertEquals(
            'The customer is saved successfully.',
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'Customer save success message is wrong'
        );
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        // Checkout
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
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $customerAddress = $customer->getAddress();
        $shippingAddress = [];
        $shippingAddress['name'] = $customerAddress[0]['firstname'] . ' ' . $customerAddress[0]['lastname'];
        $shippingAddress['address'] = $customerAddress[0]['city'] . ', '
            . $customerAddress[0]['region_id'] . ', '
            . $customerAddress[0]['postcode'] . ', '
            . 'US';
        $shippingAddress['telephone'] = $customerAddress[0]['telephone'];
        $billingAddress = [];
        $billingAddress['name'] = $customerAddress[1]['firstname'] . ' ' . $customerAddress[1]['lastname'];
        $billingAddress['address'] = $customerAddress[1]['city'] . ', '
            . $customerAddress[1]['region_id'] . ', '
            . $customerAddress[1]['postcode'] . ', '
            . 'US';
        $billingAddress['telephone'] = $customerAddress[1]['telephone'];
        return [
            'shippingAddress' => $shippingAddress,
            'billingAddress' => $billingAddress
        ];

        return ['customer' => $customer];
    }
}