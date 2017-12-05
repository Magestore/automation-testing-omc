<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:51
 */

namespace Magento\FulfilSuccess\Test\Constraint\Dashboard\ContainerPerday;

use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportDashboard;
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
    public function processAssert(ReportDashboard $reportDashboard, $chartsTitlePerday)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportDashboard->getContainerPerday()->getHighChartsButton()->isVisible(),
            'On The Backend Page, the Grid Header High Charts Button Of the Fulfilment Report->Dashboard->Container per day was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitlePerday,
            $reportDashboard->getContainerPerday()->getHighChartsTitle()->getText(),
            'The charts title Of Container Listing was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements in the Page Of the Fulfilment Report->Dashboard->Container per day was visible successfully.';
    }
}