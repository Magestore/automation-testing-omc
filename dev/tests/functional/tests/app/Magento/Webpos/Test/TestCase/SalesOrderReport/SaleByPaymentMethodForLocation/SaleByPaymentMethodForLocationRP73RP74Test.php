<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/31/18
 * Time: 1:22 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SaleByPaymentForLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByPaymentMethodForLocationRP73RP74Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation
 * RP73 & RP74
 * Precondition and setup steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method for location
 *
 * RP73
 * Steps
 * Export report to CSV file
 * Acceptance Criteria
 * CSV file will be downloaded automatically and saved on the computer
 *
 * RP74
 * Steps
 * Export report to Excel XML file
 * Acceptance Criteria
 * Excel XML file will be downloaded automatically and saved on the computer
 */
class SaleByPaymentMethodForLocationRP73RP74Test extends Injectable
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
     * SaleByPaymentForLocation page.
     *
     * @var SaleByPaymentForLocation $saleByPaymentForLocation
     */
    protected $saleByPaymentForLocation;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
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

    public function test($type)
    {
        // Preconditions
        $this->saleByPaymentForLocation->open();
        $this->saleByPaymentForLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->webPOSAdminReportDashboard->getReportDashboard()->clickTypeExport($type)->click();
        $this->webPOSAdminReportDashboard->getReportDashboard()->getButtonExport()->click();
    }
}