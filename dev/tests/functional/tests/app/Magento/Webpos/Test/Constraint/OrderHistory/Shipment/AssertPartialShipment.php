<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 2:00 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertPartialShipment extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryShipment()->isVisible(),
            'Shipment popup is not close.'
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
        $webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->isVisible(),
            'Ship button is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Partial shipment was created.';
    }
}