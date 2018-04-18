<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderStatus;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertGrandTotalInOrderDetail extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $grandTotal)
    {
        $actualGrandTotal = $webposIndex->getOrderHistoryOrderViewHeader()->getGrandTotal();
        \PHPUnit_Framework_Assert::assertEquals(
            $grandTotal,
            $actualGrandTotal,
            'Wrong Grand Total is displayed.'
            . "\nExpected: " . $grandTotal
            . "\nActual: " . $actualGrandTotal
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Order grand total is correct.';
    }
}