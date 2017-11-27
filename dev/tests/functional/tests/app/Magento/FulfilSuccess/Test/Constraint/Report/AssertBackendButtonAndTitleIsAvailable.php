<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 15:39
 */

namespace Magento\FulfilSuccess\Test\Constraint\Report;

use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportIndex;
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
            'Create Customer Address successfully.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $titleWarehouseReport,
            $reportIndex->getContainer()->getTitleWarehouseReport()->getText(),
            'Create Customer Address successfully.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconBackendFulfilStaff()->isVisible(),
            'On The Backend Page, the Grid Header Button Verify Order Of the Extension was visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconBackendFulfilStaffDaily()->isVisible(),
            'On The Backend Page, the Grid Header Button Verify Order Of the Extension was visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconFulfilWarehouse()->isVisible(),
            'On The Backend Page, the Grid Header Button Verify Order Of the Extension was visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getIconFulfilWarehouseDaily()->isVisible(),
            'On The Backend Page, the Grid Header Button Verify Order Of the Extension was visible.'
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