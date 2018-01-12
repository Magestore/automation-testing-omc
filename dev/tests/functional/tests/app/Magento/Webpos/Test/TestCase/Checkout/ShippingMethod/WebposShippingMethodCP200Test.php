<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 16:48
 */
namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
class WebposShippingMethodCP200Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products,$productCustom)
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

        //Add product custom sale
        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productCustom['name']);
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($productCustom['price']);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        sleep(1);

        //Checkout
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        // //Click icon < (Back to cart)
        $this->webposIndex->getCheckoutCartHeader()->getIconBackToCart()->click();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(1);

        //Add more product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Checkout again
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
    }
}