<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 7:57 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionShip;

use Magento\Mtf\TestCase\Scenario;

/**
 * Class WebposOrdersHistoryShipmentOH44Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionShip
 * Precondition and setup steps:
 * Go to backend > Create an order
 * Steps:
 * 1. Login webpos as a staff
 * 2. Sync order
 * 3. Go to Order history page
 * 4. Create shipment for order just created in backend
 * Acceptance Criteria:
 * 1. Close shipment popup and a shipment has created with corresponding item and Qty
 * 2. Ship action hidden on action  box
 * 3. Order status will be changed to processing
 * 4. A new notification will be display on notification icon
 */
class WebposOrdersHistoryShipmentOH44Test extends Scenario
{
    public function test()
    {
        $this->executeScenario();
    }
}