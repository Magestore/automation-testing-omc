<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/6/2018
 * Time: 9:02 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposTakePaymentOH84 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->isVisible(),
            'Visible popup confim'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getOkButton()->isVisible(),
            'Visible Ok submit'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getCancelButton()->isVisible(),
            'Visible cannel popup'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getCloseButton()->isVisible(),
            'Visible Close popup'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Order Status was correctly.";
    }
}