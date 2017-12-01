<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:44
 */

namespace Magento\FulfilSuccess\Test\Constraint\OrderListing;

use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendButtonIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint\OrderListing
 */
class AssertBackendButtonIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportIndex $reportIndex
     */
    public function processAssert(ReportIndex $reportIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getAllOrderButton()->isVisible(),
            'On The Backend Page, the Grid Header Button All Order Of the Fulfilment Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getAwaitingPaymentButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Awaiting Payment Of the Fulfilment Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getBackOrderButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Back Order Of the Fulfilment Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getHoldOrderButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Hold Order Of the Fulfilment Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getCompletedOrderButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Completed Order Of the Fulfilment Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getCanceledOrderButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Canceled Order Of the Fulfilment Extension was not visible.'
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