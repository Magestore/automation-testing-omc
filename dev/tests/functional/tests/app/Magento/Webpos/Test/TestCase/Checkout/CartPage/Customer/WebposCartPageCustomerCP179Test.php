<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 08/01/2018
 * Time: 15:47
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCartPageCustomerCP179Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer
 *
 * Precondition:
 * "1. Login webpos by a  staff
 * 2. Add some products  to cart
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * "1. Select an existing customer
 * 2. Click to edit customer
 * 3. Choose [Use Store Address] in 2 dropdowns: [Shipping address] and [Billing address] > Save
 * 4. Place order"
 *
 * Acceptance:
 * "1. Place order successfully
 * 2. In order detail, Shipping address and Billing address are corresponding to Guest's addresses"
 *
 */
class WebposCartPageCustomerCP179Test extends Injectable
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
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();

        //Create customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'webpos_guest_pi']);
        $customer->persist();
        return ['customer' => $customer];
    }

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(Customer $customer, $products, ConfigData $configData)
    {
        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
        )->run();

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Click icon addCutomer > Search name > click customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getFirstname());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Edit useStoreAdress for shipping and billing
        $this->webposIndex->getCheckoutCartHeader()->getIconEditCustomer()->click();
        $this->webposIndex->getCheckoutEditCustomer()->selectShippingAdress('Use Store Address');
        $this->webposIndex->getCheckoutEditCustomer()->selectBillingAdress('Use Store Address');
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        sleep(2);

        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        sleep(1);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId = ltrim($orderId, '#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();

        $configData = $configData->getData()['section'];
        return [
            'name' => $customer->getFirstname() . ' ' . $customer->getLastname(),
            'address' => $configData['webpos/guest_checkout/city']['value'] . ', ' . $configData['webpos/guest_checkout/region_id']['label'] .
                ', ' . $configData['webpos/guest_checkout/zip']['value'] . ', US',
            'phone' => $configData['webpos/guest_checkout/telephone']['value'],
            'orderId' => $orderId
        ];
    }
}