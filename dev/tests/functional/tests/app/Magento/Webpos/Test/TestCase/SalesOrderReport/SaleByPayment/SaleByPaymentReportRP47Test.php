<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPayment;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPayment;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;

/**
 * Report
 * RP47-RP42 - Order list by location
 *
 * Precondition
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by location
 * Steps
 * Filter by location > Show report
 *
 * Acceptance
 * Report table will statistics and show all orders created at locations just selected to filter within date range
 *
 * Class SaleByPaymentReportRP47Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPayment
 */
class SaleByPaymentReportRP47Test extends Injectable
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
     * SalesByPayment page.
     *
     * @var SalesByPayment $salesByPayment
     */
    protected $salesByPayment;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByPayment $salesByPayment
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByPayment = $salesByPayment;
    }

    /**
     * @param $shifts
     * @param null $order_status
     */
    public function test($shifts, $order_status = null)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getPaymentReport()->getPOSSalesByPaymentIcon()->click();
        $this->salesByPayment->getFilterBlock()->viewsReport($shifts);
        if ($order_status != null) {
            $order_status = array_map('trim', explode(',', $order_status));
            foreach ($order_status as $status) {
                $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($status);
                $this->salesByPayment->getActionsBlock()->showReport();
                $this->webPOSAdminReportDashboard->getReportDashboard()->waitLoader();
                if (strpos($this->webPOSAdminReportDashboard->getReportDashboard()->getFirtRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
                    if ($status == 'Complete')
                        self::assertTrue(
                            $this->webPOSAdminReportDashboard->getReportDashboard()->getLasRowDataGrid()->isVisible(),
                            'Data grid is empty'
                        );
                }
            }
        }
    }
}