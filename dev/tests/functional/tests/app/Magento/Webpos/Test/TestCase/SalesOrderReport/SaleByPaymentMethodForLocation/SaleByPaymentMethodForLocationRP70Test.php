<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/31/18
 * Time: 1:07 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Page\Adminhtml\SaleByPaymentForLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Class SaleByPaymentMethodForLocationRP70Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation
 * Precondition and setup steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method for location
 *
 * Steps
 * Filter by date range > Show report
 *
 * Acceptance Criteria
 * Report table  will statistics within date range
 */
class SaleByPaymentMethodForLocationRP70Test extends Injectable
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
     * @param SaleByPaymentForLocation $saleByPaymentForLocation
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
     */
    public function test(array $shifts)
    {
        // Preconditions
        $this->saleByPaymentForLocation->open();
        $this->saleByPaymentForLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $fromDateBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        $this->saleByPaymentForLocation->getFilterBlock()->viewsReport($shifts);
        $this->saleByPaymentForLocation->getActionsBlock()->showReport();
        $fromDateAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
        self::assertNotEquals(
            $fromDateBefore,
            $fromDateAfter,
            'In Admin. Sales Order Report. Form Order List By Payment. Time of input from date and to date is not changed.'
        );
    }
}