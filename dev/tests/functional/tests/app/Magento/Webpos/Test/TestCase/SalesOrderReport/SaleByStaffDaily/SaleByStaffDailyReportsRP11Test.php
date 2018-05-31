<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 1:40 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaffDaily;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByStaffDailyReportsRP11Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily
 * Precondition and setup steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff (Daily)
 * Steps:
 * Filter by each order status > Show report
 * Acceptance Criteria:
 * Report table only statistics data by order status just selected to filter within date range
 */
class SaleByStaffDailyReportsRP11Test extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * WebPOSAdminReportDashboard page.
     *
     * @var WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     */
    protected $webPOSAdminReportDashboard;

    /**
     * SalesByStaff page.
     *
     * @var SalesByStaffDaily $salesByStaffDaily
     */
    protected $salesByStaffDaily;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param Shift $shift
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByStaffDaily $salesByStaffDaily
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByStaffDaily = $salesByStaffDaily;
    }

    /**
     * @param array $shifts
     * @param null $order_statuses
     */
    public function test(array $shifts, $order_statuses = null)
    {
        // Preconditions
        $this->salesByStaffDaily->open();
        $this->salesByStaffDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->salesByStaffDaily->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $this->salesByStaffDaily->getActionsBlock()->showReport();
    }
}