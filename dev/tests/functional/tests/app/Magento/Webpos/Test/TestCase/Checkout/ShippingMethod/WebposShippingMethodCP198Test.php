<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 16:25
 */
namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
class WebposShippingMethodCP198Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare()
    {
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

    public function test($products)
    {

        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];
        $productMore = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Choose a method shipping
        $this->webposIndex->getCheckoutShippingMethod()->clickPOSShipping();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);

        // //Click icon < (Back to cart)
        $this->webposIndex->getCheckoutCartHeader()->getIconBackToCart()->click();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(1);

        //Add more product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($productMore->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart again
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        return ['titleExpected' => 'Shipping: POS Shipping - Store Pickup',
                'idSelected' => 'webpos_shipping_storepickup',
                'panelExpected' => true];
    }
}