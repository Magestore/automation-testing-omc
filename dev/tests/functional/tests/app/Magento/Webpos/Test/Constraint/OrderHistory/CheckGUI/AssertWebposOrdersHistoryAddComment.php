<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 8:31 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebposOrdersHistoryAddComment
 * @package Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI
 */
class AssertWebposOrdersHistoryAddComment extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param null $action
     * @param null $comment
     */
    public function processAssert(WebposIndex $webposIndex, $action = null, $comment = null)
    {
        if ($action === 'CheckGUI'){
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddComment()->getCancelButton()->isVisible(),
                'Button "Cancel" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddComment()->getSaveButton()->isVisible(),
                'Button "Send" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddComment()->getInputComment()->isVisible(),
                'Input Comment is not visible.'
            );
        }elseif ($action === 'Cancel'){
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryAddComment()->isVisible(),
                'Comment Popup is not closed.'
            );
        }elseif ($action === 'Save'){
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryAddComment()->isVisible(),
                'Comment Popup is not closed.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $comment,
                $webposIndex->getOrderHistoryOrderViewContent()->getValueComment(),
                'Comment is not correctly.'
            );
            $webposIndex->getNotification()->getNotificationBell()->click();
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Notification list is empty.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                'Add order comment successfully!',
                $webposIndex->getNotification()->getFirstNotificationText(),
                'Notification is not correctly.'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Add Comment was correctly.";
    }
}