<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/7/2018
 * Time: 8:30 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductsGridConfigProductBlockAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductImage()->isVisible(),
            'Products Grid - First product image is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductName()->isVisible(),
            'Products Grid - First product name is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->isVisible(),
            'Products Grid - First product detail button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            !empty(trim($webposIndex->getCheckoutProductList()->getFirstProductQty()->getText())),
            'Products Grid - Config product available qty is not hidden.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        // TODO: Implement toString() method.
    }
}