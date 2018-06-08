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
 * Class AssertWebposTakePaymentOH97
 * @package Magento\Webpos\Test\Constraint\OrderHistory\TakePayment
 */
class AssertWebposTakePaymentOH97 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount, $am = "$1", $remain = "$1")
    {
        \PHPUnit_Framework_Assert::assertNotTrue(
            $webposIndex->getOrderHistoryPayment()->isVisible(),
            'Visible popup takepayment'
        );
        $am = (float)substr($am, 1);
        $remain = (float)substr($remain, 1);
        $value1 = (float)$am - (float)$amount;
        $total = $webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid();
        \PHPUnit_Framework_Assert::assertEquals(
            (float)$value1,
            $remain,
            'Total paid = amount fill'
        );
        \PHPUnit_Framework_Assert::assertGreaterThan(
            (float)$amount,
            substr($total, 1),
            'Total paid = amount fill'
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