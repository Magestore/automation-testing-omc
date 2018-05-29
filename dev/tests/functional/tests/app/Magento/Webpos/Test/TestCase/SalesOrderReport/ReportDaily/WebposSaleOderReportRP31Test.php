<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 1:26 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;


/**
 * Reports
 * Testcase - RP31 - Sale by location (Daily)
 *
 * Precondition
 * Empty
 *
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location (Daily)
 *
 * Acceptance
 * 1. Redirect to Sale by location (Daily) page
 * 2. Allow filter report by date range and order status
 * 3. Order Count and Total sale will be statistical within one month and shown on Report table
 * 4. Report grouped at each location by date
 *
 * Class WebposSaleOderReportRP31Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily
 */
class WebposSaleOderReportRP31Test extends Injectable
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

    public function test(array $shifts)
    {
        //Open Sale by location daily
        $this->saleByLocationDaily->open();
        $this->saleByLocationDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        // Steps
        $this->saleByLocationDaily->getFilterBlock()->viewsReport($shifts);
        $this->saleByLocationDaily->getActionsBlock()->showReport();
    }
}