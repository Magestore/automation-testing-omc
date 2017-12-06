<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:51
 */

namespace Magento\FulfilReport\Test\Constraint\Dashboard\ContainerOrder;

use Magento\FulfilReport\Test\Page\Adminhtml\ReportDashboard;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendButtonAndTitleIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint\OrderFulfilment
 */
class AssertBackendButtonAndTitleIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportDashboard $reportDashboard
     */
    public function processAssert(ReportDashboard $reportDashboard, $chartsTitleOrder)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportDashboard->getContainerOrder()->getHighChartsButton()->isVisible(),
            'On The Backend Page, the High Chart Button Of the Fulfilment Report->Dashboard->Container Order or was not visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitleOrder,
            $reportDashboard->getContainerOrder()->getHighChartsTitle()->getText(),
            'The charts title Of Container Order was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements in the Page Of the Fulfilment Report->Dashboard->Container Order was visible successfully.';
    }
}