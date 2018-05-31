<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 4:34 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByLocationReportRP25Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByLocation
 * Pre-conditions:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location
 * Steps:
 * Filter by date range > Show report
 * Acceptance Criteria:
 * Report table will be statistical within date range
 */
class SaleByLocationReportRP25Test extends Injectable
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
     * @param array $shifts
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->salesByLocation->open();
        $this->salesByLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $fromDateBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->salesByLocation->getFilterBlock()->viewsReport($shifts);
        $this->salesByLocation->getActionsBlock()->showReport();
        $fromDateAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateBefore,
            $fromDateAfter,
            'In Admin Form Sales By Staff WebPOS Page. Time of input from date and to date is not changed.'
        );
    }
}