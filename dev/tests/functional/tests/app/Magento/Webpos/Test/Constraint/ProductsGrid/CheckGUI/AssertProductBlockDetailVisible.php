<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/8/2018
 * Time: 1:51 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductBlockDetailVisible
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI
 */
class AssertProductBlockDetailVisible extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getButtonCancel()->isVisible(),
            'Products Grid - Button Cancel is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->isVisible(),
            'Products Grid - Button Add To Checkout is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getModalTitle()->isVisible(),
            'Products Grid - Name of Product is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - Product Block Detail is available.';
    }
}