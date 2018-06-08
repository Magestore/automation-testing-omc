<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 9:06 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff;

use DateTime;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaff;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByStaffRP02Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff
 * Steps:
 * "1. Login backend
 *  2. Go to Webpos > Reports > Sale by Staff
 * Acceptance Criteria
 * "1. Redirect to Sales by staff page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped by each staff"
 */
class SaleByStaffRP02Test extends Injectable
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
     * @var SalesByStaff $salesByStaff
     */
    protected $salesByStaff;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByStaff $salesByStaff
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByStaff = $salesByStaff;
    }

    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getStaffReport()->getPOSSalesByStaffIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->salesByStaff->getTitleBlock()->getTitle(),
            'In Admin Form Sales By Staff WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->salesByStaff->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales By Staff WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales By Staff WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales By Staff WebPOS Page. The Selection Order Status is not visible.'
        );
        $datetime1 = new DateTime($fromDate->getValue());
        $datetime2 = new DateTime($toDate->getValue());
        $interval = $datetime2->diff($datetime1);
        self::assertEquals(
            1,
            $interval->m,
            'In Admin Form Order List By Location WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );

        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Sales By Staff WebPOS Page. In the Grid Sale By Staff The Column is not visible.'
            );
        }
    }
}