<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 5:24 PM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\ReportSaleOrder;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;

class AssertDateRangeByLocation extends AbstractConstraint
{
    public function processAssert(SalesByLocationDaily $salesByLocationDaily, $shifts){
        var_dump($shifts);die();
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Report show correct';
    }
}