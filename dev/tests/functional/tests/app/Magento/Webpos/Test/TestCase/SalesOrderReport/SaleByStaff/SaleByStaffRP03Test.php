<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 9:33 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaff;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;
/**
 * Interface SaleByStaffRP03Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff
 * Pre-condition
 * "1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff"
 * Steps:
 * Filter by date range > Show report"
 * Acceptance Criteria
 * Report table  will  statistical within date range
 */
class SaleByStaffRP03Test extends Injectable
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
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $fromDateInitial = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->orderListByStaff->getFilterBlock()->viewsReport($shifts);
        $this->orderListByStaff->getActionsBlock()->showReport();
        $fromDateLast = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateInitial,
            $fromDateLast,
            'In Admin Form Sales By Staff WebPOS Page. Time of input from date and to date is not changed.'
        );
    }
}