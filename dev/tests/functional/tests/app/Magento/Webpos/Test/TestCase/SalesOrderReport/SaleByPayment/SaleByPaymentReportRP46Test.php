<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 4:22 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPayment;

use DateTime;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPayment;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Report
 * Testcaes RP46 - Sale by payment method
 *
 * Precondition
 *
 *
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method
 *
 * Acceptance Criteria:
 * 1. Redirect to Sales by payment method page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped by each payment method
 *
 *
 * Class SaleByPaymentReportRP46Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPayment
 */
class SaleByPaymentReportRP46Test extends Injectable
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
     * SalesByPayment page.
     *
     * @var SalesByPayment $salesByPayment
     */
    protected $salesByPayment;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SalesByPayment $salesByPayment
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByPayment $salesByPayment
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByPayment = $salesByPayment;
    }

    /**
     * @param $pageTitle
     * @param $columns
     */
    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->salesByPayment->getTitleBlock()->getTitle(),
            'In Admin Form Sales By Payment WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->salesByPayment->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales By Payment WebPOS Page. The Input Sales Report Period Type is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales By Payment WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales By Payment WebPOS Page. The Selection Order Status is not visible.'
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
                'In Admin Form Sales By Payment WebPOS Page. In the Grid Sales By Payment The Column is not visible.'
            );
        }
    }
}