<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/31/2018
 * Time: 2:44 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Shipping\Test\Page\Adminhtml\SalesShipmentView;
use Magento\Shipping\Test\Page\Adminhtml\ShipmentIndex;

class AssertShipmentCommentAndTrackNumberInBackend extends AbstractConstraint
{
    public function processAssert(
        ShipmentIndex $shipmentIndex,
        SalesShipmentView $salesShipmentView,
        $orderId,
        $trackNumber,
        $shipmentComment
    ){
        $shipmentIndex->open();
        $shipmentIndex->getShipmentsGrid()->searchAndOpen(['order_id' => $orderId]);
        $actualShipmentComment = $salesShipmentView->getShipmentHistoryBlock()->getNoteListComment();
        \PHPUnit_Framework_Assert::assertEquals(
            $shipmentComment,
            $actualShipmentComment,
            'Shipment comment in backend is wrong.'
            . "\nExpected: " . $shipmentComment
            . "\nActual: " . $actualShipmentComment
        );
        $actualTrackNumber = $salesShipmentView->getShipmentHistoryBlock()->getTrackNumber();
        \PHPUnit_Framework_Assert::assertEquals(
            $trackNumber,
            $actualTrackNumber,
            'Track number in backend is wrong.'
            . "\nExpected: " . $trackNumber
            . "\nActual: " . $actualTrackNumber
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        // TODO: Implement toString() method.
    }
}