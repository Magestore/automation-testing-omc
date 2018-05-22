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
 * Class AssertProductDetailVisible
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI
 */
class AssertProductDetailVisible extends AbstractConstraint
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
            $webposIndex->getCheckoutProductDetail()->getSimpleProductPrice()->isVisible(),
            'Products Grid - Price of Product is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getSimpleProductAvailableQty()->isVisible(),
            'Products Grid - Available Qty of Product is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getSimpleProductImage()->isVisible(),
            'Products Grid - Image of Product is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getSimpleProductName()->isVisible(),
            'Products Grid - Name of Product is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getSimpleProductSKU()->isVisible(),
            'Products Grid - SKU of Product is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Products Grid - Product Detail is available.';
    }
}