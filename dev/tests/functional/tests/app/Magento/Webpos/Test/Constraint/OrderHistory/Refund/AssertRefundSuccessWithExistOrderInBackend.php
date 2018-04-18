<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/2/2018
 * Time: 9:50 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundSuccessWithExistOrderInBackend extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, OrderIndex $orderIndex, OrderInjectable $order, $expectStatus)
    {
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Success Message is not displayed'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'A creditmemo has been created!',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Success message's Content is Wrong"
        );
        $webposIndex->getNotification()->getNotificationBell()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getFirstNotification()->isVisible(),
            'Notification list is empty'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'A creditmemo has been created!',
            $webposIndex->getNotification()->getFirstNotificationText(),
            'Notification Content is wrong'
        );
        if ($expectStatus == 'Closed') {
            $webposIndex->getOrderHistoryOrderViewHeader()->waitForClosedStatusVisisble();
        }

        \PHPUnit_Framework_Assert::assertEquals(
            $expectStatus,
            $webposIndex->getOrderHistoryOrderViewHeader()->getStatus(),
            'Order Status is wrong'
        );

        $orderIndex->open();
        $filter = ['id' => $order->getId(), 'status' => $expectStatus];
        $errorMessage = implode(', ', $filter);
        \PHPUnit_Framework_Assert::assertTrue(
            $orderIndex->getSalesOrderGrid()->isRowVisible(array_filter($filter)),
            'Order with following data \'' . $errorMessage . '\' is absent in Orders grid.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Refund success.';
    }
}