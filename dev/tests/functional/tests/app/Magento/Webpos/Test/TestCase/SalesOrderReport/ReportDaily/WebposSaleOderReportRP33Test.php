<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 1:26 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\ReportSaleOrder\AssertFilterReportByOrderStatus;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;


/**
 * Reports
 * Testcase - RP33 - Sale by location (Daily)
 *          - RP34 - Sale by location (Daily)
 *
 * Precondition
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location (Daily)
 *
 * Steps
 * TC33 - Filter by each order status > Show report
 * TC34 - Select date range and order status to filter
 *
 * Acceptance
 * TC33 - Report table only statistics data by order status just selected to filter within date range
 * TC34 - Report table only statistic orders has status just selected within date range
 *
 * Class WebposSaleOderReportRP33Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily
 */
class WebposSaleOderReportRP33Test extends Injectable
{
    /**
     * OrderListByLocationDaily page.
     *
     * @var saleByLocationDaily
     */
    protected $saleByLocationDaily;

    /**
     * Sale by Location Daily
     *
     * @param SalesByLocationDaily $orderListByLocation
     */
    public function __inject(SalesByLocationDaily $orderListByLocation)
    {
        $this->saleByLocationDaily = $orderListByLocation;
    }

    public function test(AssertFilterReportByOrderStatus $assertFilterReportByOrderStatus, array $shifts, $order_status)
    {
        //Open Sale by location daily
        $this->saleByLocationDaily->open();
        $this->saleByLocationDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $this->saleByLocationDaily->getFilterBlock()->viewsReport($shifts);
        $order_status = array_map('trim', explode(',', $order_status));
        foreach ($order_status as $status) {
            $this->saleByLocationDaily->getFilterBlock()->setOrderStatusByTitle($status);
            $this->saleByLocationDaily->getActionsBlock()->showReport();
            $this->saleByLocationDaily->getReportBlock()->waitLoader();
            if($this->saleByLocationDaily->getReportBlock()->getSaleTotal()->isVisible()){
                $pre_sale_totle = $this->saleByLocationDaily->getReportBlock()->getSaleTotal()->getText();
                $assertFilterReportByOrderStatus->processAssert($this->saleByLocationDaily, $pre_sale_totle);
            }
        }
    }
}