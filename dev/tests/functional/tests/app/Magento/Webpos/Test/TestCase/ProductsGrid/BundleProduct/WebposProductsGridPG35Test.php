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
use Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct\AssertChildProductOnProductDetail;

/**
 * Class WebposProductsGridPG35Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG35Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertChildProductOnProductDetail
     */
    protected $assertChildProductOnProductDetail;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertChildProductOnProductDetail $assertChildProductOnProductDetail
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertChildProductOnProductDetail $assertChildProductOnProductDetail
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertChildProductOnProductDetail = $assertChildProductOnProductDetail;
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

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Close popup
        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()){
            $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        }

        // Click detail product
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        sleep(1);
        $this->webposIndex->getCheckoutProductDetail()->getQtyOfOption(1)->setValue(2);
        
        // Assert
        $this->assertChildProductOnProductDetail->processAssert($this->webposIndex, $products);

        // Click add to cart
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);

        return [
            'products' => $products
        ];
    }
}