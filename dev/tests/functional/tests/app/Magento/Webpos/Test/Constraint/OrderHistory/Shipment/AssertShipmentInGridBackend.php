<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 1:16 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Shipping\Test\Page\Adminhtml\ShipmentIndex;

class AssertShipmentInGridBackend extends AbstractConstraint
{
    public function processAssert(ShipmentIndex $shipmentIndex, $orderId)
    {
        $shipmentIndex->open();
        $shipmentIndex->getShipmentsGrid()->search(['order_id' => $orderId]);
        \PHPUnit_Framework_Assert::assertTrue(
            $shipmentIndex->getShipmentsGrid()->isRowVisible(['order_id' => $orderId], false, false),
            'Shipment is absent in Shipment grid'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Shipment is visible in shipment grid.';
    }
}