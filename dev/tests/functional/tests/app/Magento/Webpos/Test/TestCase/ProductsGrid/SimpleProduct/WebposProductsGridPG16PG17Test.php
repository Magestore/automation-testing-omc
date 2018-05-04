<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/8/2018
 * Time: 2:17 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductQtyInProductDetail;

/**
 * Class WebposProductsGridPG16PG17Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG16PG17Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;
    
    /**
     * @var AssertProductQtyInProductDetail
     */
    protected $assertProductQtyInProductDetail;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertProductQtyInProductDetail $assertProductQtyInProductDetail
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertProductQtyInProductDetail $assertProductQtyInProductDetail
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertProductQtyInProductDetail = $assertProductQtyInProductDetail;
    }

    /**
     * @param $products
     * @param $action
     * @return array
     */
    public function test(
        $products,
        $action
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        $this->webposIndex->open();

        if ($this->webposIndex->getLoginForm()->isVisible()) {
            // Login webpos
            $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\SessionInstallStep'
            )->run();
        }

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();

        $qty = 2;

        if ($action === 'add to cart'){
            $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
            /**
             *  cuz search by sku, simple product added 1 before we trigger ad to cart
             */
        }elseif ($action === 'change qty'){

            // Click on "+" two time
            $this->webposIndex->getCheckoutProductDetail()->getButtonUpQty()->click();
            $qty+=1;
            $this->webposIndex->getCheckoutProductDetail()->getButtonUpQty()->click();
            $qty+=1;
            // Click on "-" one time
            $this->webposIndex->getCheckoutProductDetail()->getButtonDownQty()->click();
            $qty-=1;
            $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        }

        return [
            'qty' => $qty
        ];
    }
}