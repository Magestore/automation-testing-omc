<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByLocation;

use DateTime;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Mtf\TestCase\Injectable;

/**
 * Report
 * RP38 - Order list by location
 *
 * Precondition
 *
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by location
 *
 * Acceptance
 * 1. Redirect to Order list by locationpage
 * 2. Allow filter report by location, date range and order status
 * 3. Report table show  all order created at each location within one month with information as: Order id, Sale total,  purchased on, Status
 * 4. Data will be group by each location
 *
 *
 * Class OrderListByLocationReportRP16Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByLocation
 */
class OrderListByLocationReportRP38Test extends Injectable
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
     * OrderListByLocation page.
     *
     * @var OrderListByLocation $orderListByLocation
     */
    protected $orderListByLocation;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByLocation $orderListLocation
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByLocation = $orderListLocation;
    }

    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getLocationReport()->getPOSOrderListLocationIcon()->click();
        sleep(1);
        self::assertEquals(
            $pageTitle,
            $this->orderListByLocation->getTitleBlock()->getTitle(),
            'In Admin Form Order List By Location WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->orderListByLocation->getTitleBlock()->getTitle()
        );
        $salesReportPeriodType = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportPeriodType();
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $salesReportPeriodType->isVisible(),
            'In Admin Form Order List By Location WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Order List By Location WebPOS Page. The Input Sales Report Period Type is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Order List By Location WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Order List By Location WebPOS Page. The Selection Order Status is not visible.'
        );
        $datetime1 = new DateTime($fromDate->getValue());
        $datetime2 = new DateTime($toDate->getValue());
        $interval = $datetime2->diff($datetime1);
        self::assertEquals(
            1,
            (int)$interval->format('%m'),
            'In Admin Form Order List By Location WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Order List By Location WebPOS Page. In the Grid Order List By Location The Column is not visible.'
            );
        }
    }
}