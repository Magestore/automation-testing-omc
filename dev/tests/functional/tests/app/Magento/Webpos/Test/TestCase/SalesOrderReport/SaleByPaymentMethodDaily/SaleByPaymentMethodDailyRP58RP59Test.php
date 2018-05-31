<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 10:07 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPaymentDaily;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByPaymentMethodDailyRP58RP59Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily
 * Precondition and setup steps
 * RP58 & RP59:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method (Daily)
 * Steps:
 * RP58:
 * Export report to CSV file
 * RP59:
 * Export report to Excel XML file
 * Acceptance Criteria:
 * RP58:
 * CSV file will be downloaded automatically and saved on the computer
 * RP59:
 * Excel XML file will be downloaded automatically and saved on the computer
 */
class SaleByPaymentMethodDailyRP58RP59Test extends Injectable
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

    public function test($type)
    {
        // Preconditions
        $this->salesByPaymentDaily->open();
        $this->salesByPaymentDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->webPOSAdminReportDashboard->getReportDashboard()->clickTypeExport($type)->click();
        $this->webPOSAdminReportDashboard->getReportDashboard()->getButtonExport()->click();
    }
}