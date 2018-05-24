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
 * Class AssertWebposTakePaymentOH96
 * @package Magento\Webpos\Test\Constraint\OrderHistory\TakePayment
 */
class AssertWebposTakePaymentOH96 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount, $am)
    {
        $remain = $webposIndex->getOrderHistoryPayment()->getRemainMoney()->getText();
        $am = (float)substr($am,1);
        $value = (float)$am - (float)$amount;
        \PHPUnit_Framework_Assert::assertEquals(
            (float)$value,
            substr($remain,1),
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