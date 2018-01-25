<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 10:00 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrdersHistoryOrderListAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderList()->getOrdersTitle()->isVisible(),
            'Orders List - Orders title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getMsWebpos()->cmenuButtonIsVisible(),
            'Order List - Menu button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getNotificationBell()->isVisible(),
            'Order List - Notification is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderList()->searchOrderIsVisible(),
            'Orders List - Search is not visible.'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderList()->getPendingStatus()->isVisible(),
            'Orders List - Pending Status is not visible.',
            $webposIndex->getOrderHistoryOrderList()->getProcessingStatus()->isVisible(),
            'Orders List - Processing Status is not visible.',
            $webposIndex->getOrderHistoryOrderList()->getCompleteStatus()->isVisible(),
            'Orders List - Complete Status is not visible.',
            $webposIndex->getOrderHistoryOrderList()->getCancelledStatus()->isVisible(),
            'Orders List - Cancelled Status is not visible.',
            $webposIndex->getOrderHistoryOrderList()->getClosedStatus()->isVisible(),
            'Orders List - Closed Status is not visible.',
            $webposIndex->getOrderHistoryOrderList()->getNotSyncStatus()->isVisible(),
            'Orders List - Not Sync Status is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Orders History - Orders List is available.';
    }
}