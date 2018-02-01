<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/22/2018
 * Time: 4:32 PM
 */
namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AssertShipmentSuccess
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Shipment
 */
class AssertShipmentSuccess extends AbstractConstraint
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

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryShipment()->isVisible(),
            'Shipment Popup is not closed'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Success Message is not displayed'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'The shipment has been created successfully.',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Success message's Content is Wrong"
        );

        $webposIndex->getNotification()->getNotificationBell()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getFirstNotification()->isVisible(),
            'Notification list is empty'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'The shipment has been created successfully.',
            $webposIndex->getNotification()->getFirstNotificationText(),
            'Notification Content is wrong'
        );
        $webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->isVisible(),
            'Ship button is not hidden.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Shipment was correctly.";
    }
}