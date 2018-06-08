<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 7:57 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily;

use DateTime;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPaymentDaily;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByPaymentMethodDailyRP54Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method (Daily)
 * Acceptance Criteria:
 * 1. Redirect to Sales by payment method (Daily) page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped by each payment method and by date
 */
class SaleByPaymentMethodDailyRP54Test extends Injectable
{
    /**
     * WebPOSAdminReportDashboard page.
     *
     * @var WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     */
    protected $webPOSAdminReportDashboard;

    /**
     * SalesByPaymentDaily page.
     *
     * @var SalesByPaymentDaily $salesByPaymentDaily
     */
    protected $salesByPaymentDaily;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByPaymentDaily $salesByPaymentDaily
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByPaymentDaily = $salesByPaymentDaily;
    }

    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentDailyIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->salesByPaymentDaily->getTitleBlock()->getTitle(),
            'In Admin Form Sales by payment method (Daily) WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' .$this->salesByPaymentDaily->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales by payment method (Daily) WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales by payment method (Daily) WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales by payment method (Daily) WebPOS Page. The Selection Order Status is not visible.'
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
                'In Admin Form Sales by payment method (Daily) WebPOS Page. In the Grid Sales by payment method (Daily) The Column is not visible.'
            );
        }
    }
}