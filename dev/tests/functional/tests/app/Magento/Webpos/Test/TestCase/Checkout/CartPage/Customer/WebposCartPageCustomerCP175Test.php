<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 08/01/2018
 * Time: 08:36
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCartPageCustomerCP175Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();
    }

    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    public function test($products)
    {

        // Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutCartHeader()->getIconBackToCart();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

//        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//
//        //Assert Place Order Success
//        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
//
//        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//
//        $name = $address->getFirstname().' '.$address->getLastname();
//        $addressText = $address->getCity().', '.$address->getRegionId().', '.$address->getPostcode().', ';
//        $phone = $address->getTelephone();
//        return [
//            'name' => $name,
//            'address' => $addressText,
//            'phone' => $phone
//        ];
    }
}