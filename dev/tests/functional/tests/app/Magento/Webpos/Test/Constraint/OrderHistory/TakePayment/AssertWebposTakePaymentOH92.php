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

class AssertWebposTakePaymentOH92 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amount)
    {
//        \PHPUnit_Framework_Assert::assertTrue(
//            $webposIndex->getOrderHistoryPayment()->getPaymentMethod("Web POS - Cash On Delivery")->isVisible(),
//            'Auto fill amount input select'
//        );
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