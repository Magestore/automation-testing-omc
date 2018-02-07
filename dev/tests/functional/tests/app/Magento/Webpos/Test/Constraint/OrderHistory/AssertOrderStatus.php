<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/22/2018
 * Time: 4:19 PM
 */
namespace Magento\Webpos\Test\Constraint\OrderHistory;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


class AssertOrderStatus extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $status)
    {
        sleep(5);
        \PHPUnit_Framework_Assert::assertEquals(
            $status,
            $webposIndex->getOrderHistoryOrderViewHeader()->getStatus(),
            'Order Status was not correctly.'
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