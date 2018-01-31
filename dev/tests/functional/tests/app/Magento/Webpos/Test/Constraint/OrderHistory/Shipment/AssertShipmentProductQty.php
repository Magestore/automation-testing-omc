<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 9:17 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentProductQty extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products, $partial = true)
    {
        foreach ($products as $item) {
            $productName = $item['product']->getName();
            if (isset($item['qtyToShip']) && $partial == true) {
                $shipQty = $item['qtyToShip'];
            } else {
                $shipQty = $item['orderQty'];
            }
            $actualShipQty = $webposIndex->getOrderHistoryOrderViewContent()->getShippedQty($productName);
            \PHPUnit_Framework_Assert::assertEquals(
                $shipQty,
                $actualShipQty,
                'Shipped qty is not equal actual shipped qty.'
                . "\nExpected: " . $shipQty
                . "\nActual: " . $actualShipQty
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
        // TODO: Implement toString() method.
    }
}