<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 1:45 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaffDaily;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class SaleByStaffDailyReportsRP12Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily
 * Precondition and setup steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff (Daily)
 * Steps:
 * Select date range and order status to filter
 * Acceptance Criteria:
 * Report table only statistic orders has status just selected within date range
 */
class SaleByStaffDailyReportsRP12Test extends Injectable
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
     * SalesByStaffDaily page.
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

        $fromDateInitial = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->salesByStaffDaily->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $this->salesByStaffDaily->getActionsBlock()->showReport();
        $fromDateLast = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateInitial,
            $fromDateLast,
            'In Admin Form Sales By Staff WebPOS Page. Time of input from date and to date is not changed.'
        );
    }
}