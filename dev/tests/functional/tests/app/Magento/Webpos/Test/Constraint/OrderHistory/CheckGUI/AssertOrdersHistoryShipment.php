<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/25/2018
 * Time: 3:46 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrdersHistoryShipment extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryShipment()->getCancelButton()->isVisible(),
            'Shipment popup - Cancel button is not visible.'
        );
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryShipment()->getSubmitButton()->isVisible(),
            'Shipment popup - Submit button is not visible.'
        );
        foreach ($products as $item) {
            $productName = $item['product']->getName();
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryShipment()->getRowItem($productName)->isVisible(),
                'Row item with product name: ' . $productName . ' is not visible.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $item['orderQty'],
                $webposIndex->getOrderHistoryShipment()->getOrderProductQty($productName),
                'Order qty in shipment popup is not equal qty in dataset'
                . "\nExpected: " . $item['orderQty']
                . "\nActual: " . $webposIndex->getOrderHistoryShipment()->getOrderProductQty($productName)

            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryShipment()->getQtyToShipInput($productName)->isVisible(),
                'Row item with product name: ' . $productName . ' - Qty to ship input is not visible.'
            );
        }
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryShipment()->getShipmentComment()->isVisible(),
            'Shipment popup - Shipment comment area is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryShipment()->getSendMailCheckbox()->isVisible(),
            'Shipment popup - Send mail checkbox is not visible.'
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