<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 3:18 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderStatus;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrderStatus extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $status)
    {
        $actualStatus = $webposIndex->getOrderHistoryOrderViewHeader()->getStatus();
        \PHPUnit_Framework_Assert::assertEquals(
            $actualStatus,
            $status,
            'Wrong status is displayed.'
            . "\nExpected: " . $status
            . "\nActual: " . $actualStatus
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Order status is correct.';
    }
}