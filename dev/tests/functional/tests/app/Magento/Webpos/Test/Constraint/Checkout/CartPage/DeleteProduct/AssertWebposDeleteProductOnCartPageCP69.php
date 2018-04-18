<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 8:45 AM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\DeleteProduct;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposDeleteProductOnCartPageCP69 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        $subtotal = 0;
//        foreach ($products as $product) {
//            $subtotal += $webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName());
//        }
        \PHPUnit_Framework_Assert::assertNotEquals(
            $subtotal,
            $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(),
            'Delete Product on Cart Page'
        );

        \PHPUnit_Framework_Assert::assertNotEquals(
            0,
            $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText(),
            'Delete Product on Cart Page'
        );

        \PHPUnit_Framework_Assert::assertNotEquals(
            0,
            $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText(),
            'Delete Product on Cart Page'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "CategoryRepository - TaxClass Page - Check Cart empty";
    }
}