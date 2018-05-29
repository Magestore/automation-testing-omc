<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 3:55 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class OrderListByStaffReportRP21RP22Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff
 * Precondition and setup steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by staff
 * Steps:
 * RP21 - Export report to CSV file
 * RP22 - Export report to Excel XML file
 * Acceptance Criteria:
 * RP21 - CSV file will be downloaded automatically and saved on the computer
 * RP22 - Excel XML file will be downloaded automatically and saved on the computer
 */
class OrderListByStaffReportRP21RP22Test extends Injectable
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

    public function test($type)
    {
        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->webPOSAdminReportDashboard->getReportDashboard()->clickTypeExport($type)->click();
        $this->webPOSAdminReportDashboard->getReportDashboard()->getButtonExport()->click();
    }
}