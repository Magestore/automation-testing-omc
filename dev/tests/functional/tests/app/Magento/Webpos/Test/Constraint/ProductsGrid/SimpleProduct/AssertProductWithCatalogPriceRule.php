<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 4:43 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductWithCatalogPriceRule
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
class AssertProductWithCatalogPriceRule extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param $catalogPriceRule
     */
    public function processAssert(WebposIndex $webposIndex, $products, $catalogPriceRule)
    {
        $productPrice = $products[0]['product']->getPrice();
        $percentDiscount = $catalogPriceRule->getDiscountAmount();
        $productPrice = $productPrice * $percentDiscount / 100;

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
            $productPrice,
            $productPriceOnCart,
            'Special Price is not equals actual product price.'
            . "\nExpected: " . $productPrice
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