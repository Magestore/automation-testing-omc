<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/26/2018
 * Time: 8:29 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentConfirmationPopupAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->isVisible(),
            'Shipment confirmation popup is not visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'Are you sure you want to ship this order?',
            $webposIndex->getModal()->getPopupMessage(),
            'Wrong message is display '
            . "\nExpected: " . 'Are you sure you want to ship this order?'
            . "\nActual: " . $webposIndex->getModal()->getPopupMessage()
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getCancelButton()->isVisible(),
            'Cancel button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getOkButton()->isVisible(),
            'OK button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getModal()->getCloseButton()->isVisible(),
            'Close button is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Shipment popup is available.';
    }
}