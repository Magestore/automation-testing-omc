<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/22/2018
 * Time: 4:02 PM
 */
namespace Magento\Webpos\Test\Constraint\OrderHistory\Payment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertPaymentSuccess
 * @package Magento\Webpos\Test\Constraint\SectionOrderHistory\Payment
 */
class AssertPaymentSuccess extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getModal()->getModalPopup()->isVisible(),
            'Confirm Popup is not closed'
        );

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryPayment()->isVisible(),
            'Payment Pop is not closed'
        );

        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Success Message is not displayed'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'Create payment successfully!',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Success message's Content is Wrong"
        );

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
            'Take Payment Button is not hiden'
        );

        $webposIndex->getNotification()->getNotificationBell()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getFirstNotification()->isVisible(),
            'Notification list is empty'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'Create payment successfully!',
            $webposIndex->getNotification()->getFirstNotificationText(),
            'Notification Content is wrong'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Payment was correctly.";
    }
}