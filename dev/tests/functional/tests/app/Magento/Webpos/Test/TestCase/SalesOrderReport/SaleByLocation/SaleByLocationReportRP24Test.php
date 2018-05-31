<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 4:22 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByLocationReportRP24Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location
 * Acceptance Criteria:
 * 1. Redirect to Sales by location page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped by each location
 */
class SaleByLocationReportRP24Test extends Injectable
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
     * SalesByLocation page.
     *
     * @var SalesByLocation $salesByLocation
     */
    protected $salesByLocation;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SalesByLocation $salesByLocation
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByLocation $salesByLocation
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByLocation = $salesByLocation;
    }

    /**
     * @param $pageTitle
     * @param $columns
     */
    public function test($pageTitle, $columns)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getLocationReport()->getPOSSalesByLocationIcon()->click();
        sleep(2);
        self::assertEquals(
            $pageTitle,
            $this->salesByLocation->getTitleBlock()->getTitle(),
            'In Admin Form Sales By Location WebPOS Page. The page title is not correct. It must be ' . $pageTitle . 'The actual ' . $this->salesByLocation->getTitleBlock()->getTitle()
        );
        $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate();
        $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate();
        $oderStatus = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportShowOrderStatuses();
        self::assertTrue(
            $fromDate->isVisible(),
            'In Admin Form Sales By Location WebPOS Page. The Input Sales Report Period Type is not visible.'
        );
        self::assertTrue(
            $toDate->isVisible(),
            'In Admin Form Sales By Location WebPOS Page. The Input To Date is not visible.'
        );
        self::assertTrue(
            $oderStatus->isVisible(),
            'In Admin Form Sales By Location WebPOS Page. The Selection Order Status is not visible.'
        );
        self::assertEquals(
            1,
            $toDate->getValue() - $fromDate->getValue(),
            'In Admin Form Sales By Location WebPOS Page. The duration time between from date and to date is not correct. It must be one month.'
        );
        foreach ($columns as $column) {
            self::assertTrue(
                $this->webPOSAdminReportDashboard->getReportDashboard()->columnIsVisible($column),
                'In Admin Form Sales By Location WebPOS Page. In the Grid Sales By Location The Column is not visible.'
            );
        }
    }
}