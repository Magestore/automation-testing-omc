<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 10:23 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaff;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class SaleByStaffRP05Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff
 * Pre-condition:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff
 * Steps:
 * Select date range and order status to filter
 * Acceptance Criteria:
 * Report table only statistic orders has status just selected within date range
 */
class SaleByStaffRP05Test extends Injectable
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
     * OrderListByStaff page.
     *
     * @var OrderListByStaff $orderListByStaff
     */
    protected $orderListByStaff;

    /**
     * SalesByStaff page.
     *
     * @var SalesByStaff $salesByStaff
     */
    protected $salesByStaff;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param OrderListByStaff $orderListByStaff
     * @param Shift $shift
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByStaff $orderListByStaff,
        SalesByStaff $salesByStaff
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByStaff = $orderListByStaff;
        $this->salesByStaff = $salesByStaff;
    }

    /**
     * @param array $shifts
     * @param null $order_statuses
     */
    public function test(array $shifts, $order_statuses=null)
    {
        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $fromDateInitial = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->orderListByStaff->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $this->orderListByStaff->getActionsBlock()->showReport();
        $fromDateLast = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateInitial,
            $fromDateLast,
            'In Admin Form Sales By Staff WebPOS Page. Time of input from date and to date is not changed.'
        );
    }
}