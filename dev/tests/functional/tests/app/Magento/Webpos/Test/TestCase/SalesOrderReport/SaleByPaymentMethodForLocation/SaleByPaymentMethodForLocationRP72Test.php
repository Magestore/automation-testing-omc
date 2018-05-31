<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/31/18
 * Time: 1:18 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\SaleByPaymentForLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByPaymentMethodForLocationRP72Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation
 * Precondition and setup steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method for location
 *
 * Steps
 * Select date range and order status to filter
 *
 * Acceptance Criteria
 * Report table only statistic orders has status just selected within date range
 */
class SaleByPaymentMethodForLocationRP72Test extends Injectable
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
     * @param Shift $shift
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
     * @param array $shifts
     * @param null $order_statuses
     */
    public function test(array $shifts, $order_statuses = null)
    {
        // Preconditions
        $this->saleByPaymentForLocation->open();
        $this->saleByPaymentForLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $fromDateInitial = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->saleByPaymentForLocation->getFilterBlock()->viewsReport($shifts);
        if ($order_statuses != null) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($order_statuses);
        }
        $this->saleByPaymentForLocation->getActionsBlock()->showReport();
        $fromDateLast = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateInitial,
            $fromDateLast,
            'In Admin Form Sales By Staff WebPOS Page. Time of input from date and to date is not changed.'
        );
    }
}