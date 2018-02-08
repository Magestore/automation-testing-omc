<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/24/2018
 * Time: 3:39 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AssertWebposOrdersHistorySendEmail
 * @package Magento\Webpos\Test\Constraint\SectionOrderHistory\CheckGUI
 */
class AssertWebposOrdersHistorySendEmail extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param null $action
     * @param null $customerEmail
     */
    public function processAssert(WebposIndex $webposIndex, $action = null, $customerEmail = null)
    {
        if ($action === 'CheckGUI'){
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistorySendEmail()->getCancelButton()->isVisible(),
                'Button "Cancel" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistorySendEmail()->getSendButton()->isVisible(),
                'Button "Send" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistorySendEmail()->getInputSendEmail()->isVisible(),
                'Input Send Email is not visible.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $customerEmail,
                $webposIndex->getOrderHistorySendEmail()->getInputSendEmail()->getValue(),
                "Input Send Email is not correctly."
            );
        }elseif ($action === 'Cancel'){
            $webposIndex->getOrderHistorySendEmail()->getCancelButton()->click();
            sleep(1);
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistorySendEmail()->isVisible(),
                'Send Email Popup is not closed.'
            );
        }elseif ($action === 'Send'){
            $webposIndex->getOrderHistorySendEmail()->getSendButton()->click();
            sleep(1);
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistorySendEmail()->isVisible(),
                'Send Email Popup is not closed.'
            );
            $webposIndex->getNotification()->getNotificationBell()->click();
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Notification list is empty.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                'An email has been sent for this order!',
                $webposIndex->getNotification()->getFirstNotificationText(),
                'Notification is not correctly.'
            );
        }elseif ($action === 'DifferentInput'){
            $webposIndex->getOrderHistorySendEmail()->getInputSendEmail()->setValue($customerEmail);
            $webposIndex->getOrderHistorySendEmail()->getSendButton()->click();
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistorySendEmail()->isVisible(),
                'Send Email Popup is not closed.'
            );
            $webposIndex->getNotification()->getNotificationBell()->click();
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getNotification()->getFirstNotification()->isVisible(),
                'Notification list is empty.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                'An email has been sent for this order!',
                $webposIndex->getNotification()->getFirstNotificationText(),
                'Notification is not correctly.'
            );
        }elseif ($action === 'InvalidInput'){
            $webposIndex->getOrderHistorySendEmail()->getInputSendEmail()->setValue($customerEmail);
            $webposIndex->getOrderHistorySendEmail()->getSendButton()->click();
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistorySendEmail()->getRequiredEmail()->isVisible(),
                'Required Email is not visible.'
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
        return "Order History - Send Email was correctly.";
    }
}