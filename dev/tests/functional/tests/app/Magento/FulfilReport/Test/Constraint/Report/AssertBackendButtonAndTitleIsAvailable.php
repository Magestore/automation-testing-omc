<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 15:39
 */

namespace Magento\FulfilReport\Test\Constraint\Report;

use Magento\FulfilReport\Test\Page\Adminhtml\ReportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendButtonAndTitleIsAvailable
 */
class AssertBackendButtonAndTitleIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportIndex $reportIndex
     */
    public function processAssert(ReportIndex $reportIndex, $titleStaffReport, $titleWarehouseReport)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $titleStaffReport,
            $reportIndex->getContainer()->getTitleStaffReport()->getText(),
            'The title of staff report was not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $titleWarehouseReport,
            $reportIndex->getContainer()->getTitleWarehouseReport()->getText(),
            'The title of warehouse report was not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconBackendFulfilStaff()->isVisible(),
            'On The Backend Page, the icon of backend fulfil staff at the place that click to FULFILMENT->REPORT was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconBackendFulfilStaffDaily()->isVisible(),
            'On The Backend Page, the icon of backend fulfil staff daily at the place that click to FULFILMENT->REPORT was notvisible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconFulfilWarehouse()->isVisible(),
            'On The Backend Page, the icon of backend fulfil warehouse at the place that click to FULFILMENT->REPORT was notvisible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconFulfilWarehouseDaily()->isVisible(),
            'On The Backend Page, the icon of backend fulfil warehouse daily at the place that click to FULFILMENT->REPORT was notvisible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements Button in the Grid Header Page Of the Extension Fulfilment was visible successfully.';
    }
}