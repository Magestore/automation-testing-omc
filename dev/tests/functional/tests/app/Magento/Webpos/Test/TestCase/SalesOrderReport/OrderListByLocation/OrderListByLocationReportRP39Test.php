<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByLocation;

use DateTime;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Mtf\TestCase\Injectable;

/**
 * Report
 * RP39-RP42 - Order list by location
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
 *
 * Class OrderListByLocationReportRP16Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByLocation
 */
class OrderListByLocationReportRP39Test extends Injectable
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
     * OrderListByLocation page.
     *
     * @var OrderListByLocation $orderListByLocation
     */
    protected $orderListByLocation;

    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByLocation $orderListLocation
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByLocation = $orderListLocation;
    }

    public function test($shifts, $order_status = null)
    {
        // Preconditions
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getLocationReport()->getPOSOrderListLocationIcon()->click();
        $this->orderListByLocation->getFilterBlock()->viewsReport($shifts);
        if ($this->webPOSAdminReportDashboard->getReportDashboard()->getLocation()) {
            $this->webPOSAdminReportDashboard->getReportDashboard()->setLocation($shifts['period_type']);
        }
        if ($order_status != null) {
            $order_status = array_map('trim', explode(',', $order_status));
            foreach ($order_status as $status) {
                $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($status);
                $this->orderListByLocation->getActionsBlock()->showReport();
                $this->webPOSAdminReportDashboard->getReportDashboard()->waitLoader();
                if (strpos($this->webPOSAdminReportDashboard->getReportDashboard()->getFirtRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
                    $statusOrder = $this->webPOSAdminReportDashboard->getReportDashboard()->getStatusOrder()->getText();
                    self::assertEquals(
                        $status,
                        $statusOrder,
                        'In Admin Form Order List By Location WebPOS Page. Status is not updated. It must be ' . $statusOrder
                    );
                }
            }
        } else {
            $this->orderListByLocation->getActionsBlock()->showReport();
        }
        if (isset($shifts['period_type'])) {
            $locationName = $this->webPOSAdminReportDashboard->getReportDashboard()->getLocationName()->getText();
            if ('We couldn\'t find any records.' != $locationName) {
                self::assertEquals(
                    $shifts['period_type'],
                    $locationName,
                    'In Admin Form Order List By Location WebPOS Page. The period type was not updated. It must be ' . $shifts['period_type']
                );
            }
        }
        if (isset($shifts['from']) && isset($shifts['to'])) {
            $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
            $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate()->getValue();
            $fromDate = new DateTime($fromDate);
            $toDate = new DateTime($toDate);
            if (strpos($this->webPOSAdminReportDashboard->getReportDashboard()->getFirtRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
                $dateOfFirstRow = $this->webPOSAdminReportDashboard->getReportDashboard()->getFirstDateGrid();
                $dateOfFirstRow = new DateTime($dateOfFirstRow);
                self::assertTrue(
                    (int)$dateOfFirstRow->diff($fromDate)->format('%R%a') <= 0 &&
                    (int)$dateOfFirstRow->diff($toDate)->format("%R%a") >= 0
                );
            }
            if (strpos($this->webPOSAdminReportDashboard->getReportDashboard()->getLasRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
                $dateOfLastRow = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastDateGrid();
                $dateOfLastRow = new DateTime($dateOfLastRow);
                self::assertTrue(
                    (int)$dateOfLastRow->diff($fromDate)->format('%R%a') <= 0 &&
                    (int)$dateOfLastRow->diff($toDate)->format("%R%a") >= 0
                );
            }
        }
    }
}