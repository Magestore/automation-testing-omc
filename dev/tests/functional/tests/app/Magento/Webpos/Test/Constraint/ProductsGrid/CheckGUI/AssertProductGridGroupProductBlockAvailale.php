<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/12/2018
 * Time: 1:44 PM
 */
namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductGridGroupProductBlockAvailale extends AbstractConstraint
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
            $webposIndex->getCheckoutProductList()->getFirstProductQty()->isVisible(),
            'Products Grid - Config product available qty is not hidden.'
        );
        $price = $webposIndex->getCheckoutProductList()->getFirstProductPrice();
        \PHPUnit_Framework_Assert::assertEquals(
            0,
            (float) $price,
            'Group product price is wrong.'
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