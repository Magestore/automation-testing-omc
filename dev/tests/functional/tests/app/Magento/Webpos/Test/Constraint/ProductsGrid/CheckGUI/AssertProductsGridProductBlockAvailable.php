<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/5/2018
 * Time: 2:40 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductsGridProductBlockAvailable
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI
 */
class AssertProductsGridProductBlockAvailable extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductImage()->isVisible(),
            'Products Grid - First product image is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->getFirstProductName()->isVisible(),
            'Products Grid - First product name is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - Product block is available.';
    }
}