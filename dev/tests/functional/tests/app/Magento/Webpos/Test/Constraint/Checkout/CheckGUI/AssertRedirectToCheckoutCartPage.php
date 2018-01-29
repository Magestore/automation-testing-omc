<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 3:42 PM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertRedirectToCheckoutCartPage
 * @package Magento\Webpos\Test\Constraint\Checkout\CheckGUI
 */
class AssertRedirectToCheckoutCartPage extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductList()->isVisible(),
            'On the Frontend Page - Product List was not visible.'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutWebposCart()->isVisible(),
            'On the Frontend Page - Cart was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the Frontend Page - Check out cart page was visible.";
    }
}