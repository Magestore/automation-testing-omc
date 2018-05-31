<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/2/2018
 * Time: 9:19 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund;

use Magento\Mtf\TestCase\Scenario;

/**
 * Class WebposOrdersHistoryRefundOrderCreateOnBackendOH80Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 * Precondition and setup steps:
 * 1. Go to backend
 * 2. Create an order
 * 3. Invoice order
 * Steps:
 * 1. Login webpos as a staff
 * 2. Refund order just created"
 * Acceptance Criteria:
 * 1. A creditmemo has been created
 * 2. There is a new notification
 * 3. Order status will be update on order detail page
 * 4. Order in backend will be updated too"
 */
class WebposOrdersHistoryRefundOrderCreateOnBackendOH80Test extends Scenario
{
    public function test()
    {
        $this->executeScenario();
    }
}