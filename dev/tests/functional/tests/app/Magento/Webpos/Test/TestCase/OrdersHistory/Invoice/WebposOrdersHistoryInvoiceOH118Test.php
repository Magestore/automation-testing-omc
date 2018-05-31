<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/2/2018
 * Time: 2:36 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Scenario;

/**
 * Class WebposOrdersHistoryInvoiceOH118Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 * Precondition and setup steps:
 * 1. Go to backend
 * 2. Create an order
 * Steps:
 * 1. Login webpos as a staff
 * 2. Go to order details page
 * 3. Create payment
 * 4.Create Invoice
 * Acceptance Criteria:
 * 1. Create payment and invoice successfully
 * 2. There are two new notifications
 * 3. Order status will be changed to processing
 */
class WebposOrdersHistoryInvoiceOH118Test extends Scenario
{
    public function test()
    {
        $this->executeScenario();
    }
}