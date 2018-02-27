<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 9:46 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductPriceInCatalog
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertProductPriceInCatalog extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param $taxRate
     */
    public function processAssert(WebposIndex $webposIndex, $products, $taxRate)
    {
        $productPrice = $products[0]['product']->getPrice();
        $productPriceOnPage = (float) $webposIndex->getCheckoutProductList()->getFirstProductPrice();
        \PHPUnit_Framework_Assert::assertEquals(
            $productPrice,
            $productPriceOnPage,
            'Product price is not equals actual product price.'
            . "\nExpected: " . $productPrice
            . "\nActual: " . $productPriceOnPage
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product price was correctly.';
    }
}