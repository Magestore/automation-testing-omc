<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 09/01/2018
 * Time: 07:28
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCartPageCustomerCP182Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer
 *
 * Precondition:
 * "1. Login webpos by a  staff
 * 2. Add some products  to cart
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * "1. Click on Customer icon > click [Create customer] button
 * 2. Create a new customer with Shipping address and Billing address
 * 3. Place order"
 *
 * Acceptance:
 * "1. Place order sucessfully
 * 2. In order detail, shipping address and billing address are the customer address"
 *
 */
class WebposCartPageCustomerCP182Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Prepare data.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
        )->run();
    }

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(Customer $customer, Address $address, $products)
    {
        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // fill info cutermer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
        $this->webposIndex->getCheckoutAddCustomer()->setFieldWithoutShippingAndBilling($customer->getData());
        sleep(1);
        $this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
        $this->webposIndex->getCheckoutAddShippingAddress()->setFieldAddress($address->getData());
        sleep(1);
        $this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
        sleep(1);
        $this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();
        sleep(2);
        //Add product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId = ltrim($orderId, '#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();

        return [
            'name' => $address->getFirstname() . ' ' . $address->getLastname(),
            'address' => $address->getCity() . ', ' . $address->getRegion() . ', ' . $address->getPostcode() . ', US',
            'phone' => $address->getTelephone(),
            'orderId' => $orderId
        ];
    }

}