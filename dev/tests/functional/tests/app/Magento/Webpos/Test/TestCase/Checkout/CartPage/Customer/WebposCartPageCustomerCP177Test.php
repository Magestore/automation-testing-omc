<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 08/01/2018
 * Time: 14:18
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Customer\Test\Fixture\Customer;

class WebposCartPageCustomerCP177Test extends Injectable
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

    public function test(Customer $customer, $products)
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

        //Click icon addCutomer > Search name > click customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getFirstname());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Add products to cart
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
        sleep(2);

        //Get orderId
        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId= ltrim ($orderId,'#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();

        return [
            'name' => $customer->getAddress()[0]['firstname'].' '.$customer->getAddress()[0]['lastname'],
            'address' => $customer->getAddress()[0]['city'].', '.$customer->getAddress()[0]['region'].', '.$customer->getAddress()[0]['postcode'].', US',
            'phone' =>  $customer->getAddress()[0]['telephone'],
            'orderId' => $orderId
        ];
    }
}