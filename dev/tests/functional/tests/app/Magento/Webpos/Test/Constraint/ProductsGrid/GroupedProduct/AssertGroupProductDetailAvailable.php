<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/8/2018
 * Time: 10:35 AM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\GroupedProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertGroupProductDetailAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getCancelButton()->isVisible(),
            'Cancel button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->isVisible(),
            'Add to cart button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductDetail()->getProductOptionsWrap()->isVisible(),
            'Product options is not visible.'
        );
        $webposIndex->getCheckoutProductDetail()->getCancelButton()->click();
        sleep(1);
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutProductDetail()->isVisible(),
            'Group Product detail is not hidden.'
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