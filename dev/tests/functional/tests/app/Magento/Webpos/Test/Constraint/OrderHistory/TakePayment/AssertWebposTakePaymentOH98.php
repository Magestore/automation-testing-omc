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

class AssertWebposTakePaymentOH98 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
            'Button take payment is not visible correctly.'
        );
        $total = $webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid();
        \PHPUnit_Framework_Assert::assertGreaterThan(
            $amount,
            substr($total,1),
            'Total paid = amount fill'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            2,
            $webposIndex->getNotification()->getCountNotification()->getText(),
            'TaxClass page - CategoryRepository. Count Notification'
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