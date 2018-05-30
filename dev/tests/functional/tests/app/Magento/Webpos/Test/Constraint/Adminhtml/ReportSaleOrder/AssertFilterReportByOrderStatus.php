<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/29/18
 * Time: 10:11 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\ReportSaleOrder;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;

class AssertFilterReportByOrderStatus extends AbstractConstraint
{

    public function processAssert(SalesByLocationDaily $salesByLocationDaily, $pre_sale_total)
    {
        if ($salesByLocationDaily->getReportBlock()->getSaleTotal()->isVisible()) {
            $sale_total = $salesByLocationDaily->getReportBlock()->getSaleTotal()->getText();
            \PHPUnit_Framework_Assert::assertEquals(
                $pre_sale_total,
                $sale_total,
                'Table didn\'t change'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Filter work correct';
    }
}