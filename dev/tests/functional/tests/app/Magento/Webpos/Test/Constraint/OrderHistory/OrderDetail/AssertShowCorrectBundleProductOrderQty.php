<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/24/18
 * Time: 4:09 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderDetail;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShowCorrectBundleProductOrderQty extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $qty)
    {
        $orderQty = $webposIndex->getOrderHistoryOrderViewContent()->getFirstBundleProductQty()->getText();
        $orderQty = explode(' ', $orderQty);
        $orderQty = end($orderQty);
        \PHPUnit_Framework_Assert::assertEquals(
            $qty,
            (int)$orderQty,
            'Order Quantity was displayed correctly'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Bundle product quantity was show correctly';
    }
}