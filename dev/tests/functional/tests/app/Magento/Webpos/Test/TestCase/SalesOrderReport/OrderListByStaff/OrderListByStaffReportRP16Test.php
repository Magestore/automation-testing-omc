<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Mtf\TestCase\Injectable;

/**
 * Class OrderListByStaffReportRP16Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by staff
 * Acceptance Criteria:
 * 1. Redirect to Order list by staff page
 * 2. Allow filter report by staff, date range and order status
 * 3. Report table show  all order created by each staff within one month with information as: Order id, Sale total,  purchased on, Status
 * 4. Data will be group by each staff
 */
class OrderListByStaffReportRP16Test extends Injectable
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

    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getStaffReport()->getPOSOrderListStaffIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->orderListByStaff->getTitleBlock()->getTitle(),
            'In Admin Form Order List By Staff WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->orderListByStaff->getTitleBlock()->getTitle()
        );
        $salesReportPeriodType = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportPeriodType();
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $salesReportPeriodType->isVisible(),
            'In Admin Form Order List By Staff WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Order List By Staff WebPOS Page. The Input Sales Report Period Type is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Order List By Staff WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Order List By Staff WebPOS Page. The Selection Order Status is not visible.'
        );
        self::assertEquals(
            1,
            $toDate->getValue() - $fromDate->getValue(),
            'In Admin Form Order List By Staff WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Order List By Staff WebPOS Page. In the Grid Order List By Staff The Column is not visible.'
            );
        }
    }
}