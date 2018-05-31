<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/31/18
 * Time: 11:28 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SaleByPaymentForLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByPaymentMethodForLocationRP69Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method for location
 *
 * Acceptance Criteria
 * 1. Redirect to Sale by payment method for location page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped by each payment method and by location
 */
class SaleByPaymentMethodForLocationRP69Test extends Injectable
{
    /**
     * WebPOSAdminReportDashboard page.
     *
     * @var WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     */
    protected $webPOSAdminReportDashboard;

    /**
     * SaleByPaymentForLocation page.
     *
     * @var SaleByPaymentForLocation $saleByPaymentForLocation
     */
    protected $saleByPaymentForLocation;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SaleByPaymentForLocation $saleByPaymentForLocation
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SaleByPaymentForLocation $saleByPaymentForLocation
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->saleByPaymentForLocation = $saleByPaymentForLocation;
    }

    /**
     * @param $pageTitle
     * @param $columns
     */
    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentMethodLocationIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->saleByPaymentForLocation->getTitleBlock()->getTitle(),
            'In Admin Form Sales by payment method WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->saleByPaymentForLocation->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales by payment method WebPOS Page. The Input From Date is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales by payment method WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales by payment method WebPOS Page. The Selection Order Status is not visible.'
        );
        self::assertGreaterThan(
            $fromDate->getValue(),
            $toDate->getValue(),
            'In Admin Form Sales by payment method WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Sales by payment method WebPOS Page. In the Grid Sales by payment method The Column is not visible.'
            );
        }
    }
}