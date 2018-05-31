<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 1:00 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaffDaily;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByStaffDailyReportsRP09Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff (Daily)
 * Acceptance Criteria:
 * 1. Redirect to Sales By Staff (Daily) page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped by each staff by date"
 */
class SaleByStaffDailyReportsRP09Test extends Injectable
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

    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getStaffReport()->getPOSSalesByStaffDailyIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->salesByStaffDaily->getTitleBlock()->getTitle(),
            'In Admin Form Sales By Staff (Daily) WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->salesByStaffDaily->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales By Staff (Daily) WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales By Staff (Daily) WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales By Staff (Daily) WebPOS Page. The Selection Order Status is not visible.'
        );
        self::assertEquals(
            1,
            $toDate->getValue() - $fromDate->getValue(),
            'In Admin Form Sales By Staff (Daily) WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Sales By Staff (Daily) WebPOS Page. In the Grid Sales By Staff (Daily) The Column is not visible.'
            );
        }
    }
}