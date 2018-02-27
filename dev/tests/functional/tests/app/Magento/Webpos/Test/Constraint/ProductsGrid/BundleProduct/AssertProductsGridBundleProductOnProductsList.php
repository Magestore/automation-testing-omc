<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/12/2018
 * Time: 1:52 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductsGridBundleProductOnProductsList
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct
 */
class AssertProductsGridBundleProductOnProductsList extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $productName = $products[0]['product']->getName();
        $productNameOnPage = $webposIndex->getCheckoutProductList()->getFirstProductName()->getText();

        \PHPUnit_Framework_Assert::assertEquals(
            $productName,
            $productNameOnPage,
            'Products Grid - Product Name is not correctly.'
        );

        $productQtyOnPage = $webposIndex->getCheckoutProductList()->getFirstProductQty()->getText();
        $productQtyOnPage = (int) str_replace(' item(s)','', $productQtyOnPage);
//        \PHPUnit_Framework_Assert::assertFalse(
//            $webposIndex->getCheckoutProductList()->getFirstProductQty()->isVisible(),
//            'Available Qty is visible'
//        );

        \Zend_Debug::dump($productQtyOnPage);

        $productPriceOnPage = (float) substr($webposIndex->getCheckoutProductList()->getFirstProductPrice(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            0,
            $productPriceOnPage,
            'Products Grid - Product Qty is not correctly.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - Product Information is correctly.';
    }
}