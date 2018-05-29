<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 4:52 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation;

use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocation;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Mtf\TestCase\Injectable;
/**
 * Class SaleByLocationReportRP26Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation
 * Precondition and setup steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location
 * Steps:
 * Filter by each order status > Show report
 * Acceptance Criteria:
 * Report table only statistics data by order status just selected to filter within date range
 */
class SaleByLocationReportRP26Test extends Injectable
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
     * @param Shift $shift
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
     * @param array $shifts
     * @param null $order_statuses
     */
    public function test(array $shifts, $order_statuses = null)
    {
        // Preconditions
        $this->salesByLocation->open();
        $this->salesByLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $this->salesByLocation->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $this->salesByLocation->getActionsBlock()->showReport();
    }
}