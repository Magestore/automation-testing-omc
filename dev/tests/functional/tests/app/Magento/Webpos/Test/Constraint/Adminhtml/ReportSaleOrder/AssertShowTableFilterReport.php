<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 3:44 PM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\ReportSaleOrder;

use Magento\Webpos\Test\Page\Adminhtml\SalesByLocationDaily;

class AssertShowTableFilterReport extends \Magento\Mtf\Constraint\AbstractConstraint
{

    public function processAssert(SalesByLocationDaily $salesByLocationDaily, $fields)
    {
        $fields = array_map('trim', explode(',', $fields));
        foreach ($fields as $field) {
            $this->assertField($salesByLocationDaily, $field);
        }
    }

    private function assertField(SalesByLocationDaily $salesByLocationDaily, $title)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $salesByLocationDaily->getReportBlock()->getTableFieldByTitle($title)->isVisible(),
            'Title ' . $title . ' was  incorrect'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Sale table showed correct';
    }
}