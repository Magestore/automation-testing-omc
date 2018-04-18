<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 2:22 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductWithSpecialPrice
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertProductWithSpecialPrice extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $productSpecialPrice = $products[0]['product']->getSpecialPrice();

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductRegularPrice()->isVisible(),
            'Regular Price of Product is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductFinalPrice()->isVisible(),
            'Final Price of Product is not visible.'
        );

        $productPriceOnCart = (float) substr($webposIndex->getCheckoutCartItems()->getCartItemPrice($products[0]['product']->getName())->getText(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $productSpecialPrice,
            $productPriceOnCart,
            'Special Price is not equals actual product price.'
            . "\nExpected: " . $productSpecialPrice
            . "\nActual: " . $productPriceOnCart
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