<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 3:20 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;
/**
 * Class OrderListByStaffReportRP17Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff
 * Precondition and setup steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by staff
 * Steps:
 * Filter by staff > Show report
 * Acceptance Criteria:
 * Report table will statistics and show all orders of staffs just selected to filter  within date range
 */
class OrderListByStaffReportRP17Test extends Injectable
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
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param Shift $shift
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByStaff $orderListByStaff
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByStaff = $orderListByStaff;
    }

    /**
     * @param array $shifts
     * @param null $order_statuses
     */
    public function test(array $shifts, $order_statuses = null)
    {
        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->orderListByStaff->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $staffName = $this->webPOSAdminReportDashboard->getReportDashboard()->getStaffName()->getText();
        $this->orderListByStaff->getActionsBlock()->showReport();
        $statusOrder = $this->webPOSAdminReportDashboard->getReportDashboard()->getStatusOrder()->getText();
        self::assertEquals(
            $shifts['period_type'],
            $staffName,
            'In Admin Form Order List By Staff WebPOS Page. The period type was not updated. It must be '.$shifts['period_type']
        );
        if ($order_statuses != null) {
            self::assertEquals(
                $order_statuses,
                $statusOrder,
                'In Admin Form Order List By Staff WebPOS Page. Status is not updated. It must be '.$order_statuses
            );
        }
    }
}