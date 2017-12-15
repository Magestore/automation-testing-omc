<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 16:39
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckoutPageVisible
 * @package Magento\Webpos\Test\Constraint\Checkout\CheckGUI
 */
class AssertWebposCheckoutPageVisible extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getTopTotalPrice()->isVisible(),
            'On the Frontend Page - The Top Total Price at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getRemainMoney()->isVisible(),
            'On the Frontend Page - The Remain money at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->isVisible(),
            'On the Frontend Page - The Button ADD PAYMENT at the web POS Cart was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->isVisible(),
            'On the Frontend Page - The Button PLACE ORDER PAYMENT at the web POS Cart was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the Frontend Page - All the Button, Icon at the web POS Cart were visible and the value was uodated  successfully.";
    }
}