<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/13/2018
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductWithSpecialPrice;

/**
 * Class WebposProductsGridPG32Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG32Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertProductWithSpecialPrice
     */
    protected $assertProductWithSpecialPrice;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertProductWithSpecialPrice $assertProductWithSpecialPrice
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertProductWithSpecialPrice $assertProductWithSpecialPrice
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertProductWithSpecialPrice = $assertProductWithSpecialPrice;
    }

    /**
     * @param $products
     * @return array
     */
    public function test(
        $products
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Pending

//        // Login webpos
//        $staff = $this->objectManager->getInstance()->create(
//            'Magento\Webpos\Test\TestStep\LoginWebposStep'
//        )->run();
//
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//
//        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
//        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//
//        // Assert Price Of Product
//        $this->assertProductWithSpecialPrice->processAssert($this->webposIndex, $products);
//        // End Assert Price Of Product
//
//        // Choose first product
//        $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($products[0]['product']->getBundleSelections()['products'][0][0]->getName())->click();
//        sleep(1);
//        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//
//        // Check out and Place Order
//        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//
//        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//
//        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
//        // Placer Order
//
//        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
//
//        return [
//            'products' => $products,
//            'orderId' => $orderId
//        ];
    }
}