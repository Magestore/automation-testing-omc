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
 * Testcase - RP32 - Sale by location (Daily)
 *
 * Precondition
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by location (Daily)
 *
 * Steps
 * Filter by date range > Show report
 *
 * Acceptance
 * Report table  will statistics within date range
 *
 * Class WebposSaleOderReportRP32Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\ReportDaily
 */
class WebposSaleOderReportRP32Test extends Injectable
{
    /**
     * SaleByLocationDaily page.
     *
     * @var SalesByLocationDaily
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