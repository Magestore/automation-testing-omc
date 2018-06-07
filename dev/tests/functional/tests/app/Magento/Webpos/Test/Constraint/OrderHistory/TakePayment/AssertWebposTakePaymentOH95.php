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

/**
 * Class AssertWebposTakePaymentOH95
 * @package Magento\Webpos\Test\Constraint\OrderHistory\TakePayment
 */
class AssertWebposTakePaymentOH95 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        $total = $webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid();
        \PHPUnit_Framework_Assert::assertGreaterThan(
            $amount,
            (int)substr($total, 1),
            'Total paid not greater amount fill'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
            'Take payement button didn\'t show'
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