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