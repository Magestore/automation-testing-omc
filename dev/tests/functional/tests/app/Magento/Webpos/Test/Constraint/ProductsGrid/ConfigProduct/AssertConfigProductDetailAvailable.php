<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/8/2018
 * Time: 10:35 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\ConfigProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertConfigProductDetailAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getCancelButton()->isVisible(),
            'Cancel button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getConfigProductName()->isVisible(),
            'Config product name is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getConfigProductSku()->isVisible(),
            'Config product sku is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getPrice()->isVisible(),
            'Config product price is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getProductQtyInput()->isVisible(),
            'Config product qty add to cart is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->isVisible(),
            'Add to cart button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'Availability: 0 child item(s)',
            $webposIndex->getCheckoutProductDetail()->getAvailability()->getText(),
            'Availability is wrong.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getProductOptionsWrap()->isVisible(),
            'Product options is not visible.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Config product detail is availale.';
    }
}