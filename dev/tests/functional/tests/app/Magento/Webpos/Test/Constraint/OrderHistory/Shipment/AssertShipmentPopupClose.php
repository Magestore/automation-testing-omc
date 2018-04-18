<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/26/2018
 * Time: 8:17 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentPopupClose extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryShipment()->isVisible(),
            'Orders History - Shipment popup is not close.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Shipment popup is absent.';
    }
}