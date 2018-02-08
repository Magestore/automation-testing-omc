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

class AssertWebposTakePaymentOH96 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        $remain = $webposIndex->getOrderHistoryPayment()->getRemainMoney()->getText();
        \PHPUnit_Framework_Assert::assertEquals(
            $amount,
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