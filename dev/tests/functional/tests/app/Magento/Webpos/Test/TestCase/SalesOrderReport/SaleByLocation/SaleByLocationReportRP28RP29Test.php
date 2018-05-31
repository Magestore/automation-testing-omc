<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 5:08 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByLocationReportRP28RP29Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation
 * Precondition and setup steps;
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location
 * Steps:
 * Export report to Excel XML file
 * Acceptance Criteria:
 * Excel XML file will be downloaded automatically and saved on the computer
 */
class SaleByLocationReportRP28RP29Test extends Injectable
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
     * @param $type
     */
    public function test($type)
    {
        // Preconditions
        $this->salesByLocation->open();
        $this->salesByLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->webPOSAdminReportDashboard->getReportDashboard()->clickTypeExport($type)->click();
        $this->webPOSAdminReportDashboard->getReportDashboard()->getButtonExport()->click();
    }
}