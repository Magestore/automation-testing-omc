<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/8/2018
 * Time: 8:08 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\ConfigProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertConfigProductPopupAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getCancelButton()->isVisible(),
            'Cancel button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getProductName()->isVisible(),
            'Product name is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getPrice()->isVisible(),
            'Product price is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getProductOptionsWrap()->isVisible(),
            'Product attribute options is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getProductQtyInput()->isVisible(),
            'Product qty input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->isVisible(),
            'Add To Cart button is not visible.'
        );
        $webposIndex->getCheckoutProductDetail()->getCancelButton()->click();
        sleep(1);
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutProductDetail()->isVisible(),
            'Config product popup is not hidden.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Configuable product popup is available.';
    }
}