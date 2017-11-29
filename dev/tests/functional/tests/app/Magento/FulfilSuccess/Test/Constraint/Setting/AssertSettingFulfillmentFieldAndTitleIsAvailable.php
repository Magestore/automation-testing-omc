<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 11/29/2017
 * Time: 8:50 AM
 */

namespace Magento\FulfilSuccess\Test\Constraint\Setting;

use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertSettingFulfillmentFieldAndTitleIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint\Setting
 */
class AssertSettingFulfillmentFieldAndTitleIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportIndex $reportIndex
     */
    public function processAssert(ReportIndex $reportIndex, $titleFulfillmentSection)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $titleFulfillmentSection,
            $reportIndex->getContainer()->getTitleFulfillmentSection()->getText(),
            'Title Fulfillment Setting Section Is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getFirstFieldFulfillment()->isVisible(),
            'On The Backend Page, the Field Section Verify Fulfillment Setting Of the Extension was not visible.'
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