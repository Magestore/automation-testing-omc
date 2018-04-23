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

class AssertWebposTakePaymentOH93 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryPayment()->isVisible(),
            'Visible popup takepayment'
        );
        $total = $webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid();
        \PHPUnit_Framework_Assert::assertEquals(
            $amount,
            substr($total, 1),
            'Visible popup takepayment'
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