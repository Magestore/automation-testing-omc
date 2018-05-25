<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 8:23 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\ReportPage;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Mtf\TestCase\Injectable;
/**
 * Class ReportPageRP01Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\ReportPage
 * Steps
 * "1. Login backend
 * 2. Go to Webpos > Reports"
 * Acceptance Criteria
 * "1. Redirect to Reports page includding 3 groups: Staff report, Location report, Payment report
 * 2. Each group includding corresponding report tables "
 */
class ReportPageRP01Test extends Injectable
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
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @return void
     */
    public function __inject(WebPOSAdminReportDashboard $webPOSAdminReportDashboard)
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
    }

    public function test()
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getReportDashboard()->getAdminReportWebpos()->isVisible(),
            'In backend. Form Admin Report Webpos Page is not visible.'
        );
        //Assert Form Staff Report
        self::assertEquals(
            'STAFF REPORT',
            $this->webPOSAdminReportDashboard->getStaffReport()->getPanelHeading()->getText(),
            'In Admin Form Report Webpos Page. The title Staff Report is not correct.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getStaffReport()->getPOSSalesByStaffIcon()->isVisible(),
            'In Admin Form Staff Report Webpos Page. Table Sales By Staff is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getStaffReport()->getPOSSalesByStaffDailyIcon()->isVisible(),
            'In Admin Form Staff Report Webpos Page. Table Sales By Staff Daily is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getStaffReport()->getPOSOrderListStaffIcon()->isVisible(),
            'In Admin Form Staff Report Webpos Page. Table Order List Staff is not visible.'
        );
        //Assert Form Location Report
        self::assertEquals(
            'LOCATION REPORT',
            $this->webPOSAdminReportDashboard->getLocationReport()->getPanelHeading()->getText(),
            'In Admin Form Report Webpos Page. The title Location Report is not correct.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getLocationReport()->getPOSSalesByLocationIcon()->isVisible(),
            'In Admin Form Staff Report Webpos Page. Table Sales By Location is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getLocationReport()->getPOSSalesByLocationDailyIcon()->isVisible(),
            'In Admin Form Staff Report Webpos Page. Table Sales By Location Daily is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getLocationReport()->getPOSOrderListLocationIcon()->isVisible(),
            'In Admin Form Location Report Webpos Page. Table Order List Location is not visible.'
        );
        //Assert Form Payment Report
        self::assertEquals(
            'PAYMENT REPORT',
            $this->webPOSAdminReportDashboard->getPaymentReport()->getPanelHeading()->getText(),
            'In Form Admin Payment Webpos Page. The title Payment Report is not correct.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentIcon()->isVisible(),
            'In Admin Form Payment Report Webpos Page. Table Sales By Payment is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentDailyIcon()->isVisible(),
            'In Admin Form Payment Report Webpos Page. Table Sales By Payment Daily is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSOrderListPaymentIcon()->isVisible(),
            'In Admin Form Payment Report Webpos Page. Table Order List Payment is not visible.'
        );
        self::assertTrue(
            $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentMethodLocationIcon()->isVisible(),
            'In Admin Form Payment Report Webpos Page. Table Order List Payment Method Location is not visible.'
        );
    }
}



