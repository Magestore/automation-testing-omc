<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 09/01/2018
 * Time: 07:28
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Fixture\Address;

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
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
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

        //Login webpos
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

        //Checkout
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
        $orderId= ltrim ($orderId,'#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();

        return [
            'name' => $address->getFirstname().' '.$address->getLastname(),
            'address' => $address->getCity().', '.$address->getRegion().', '.$address->getPostcode().', US',
            'phone' =>  $address->getTelephone(),
            'orderId' => $orderId
        ];
    }

}