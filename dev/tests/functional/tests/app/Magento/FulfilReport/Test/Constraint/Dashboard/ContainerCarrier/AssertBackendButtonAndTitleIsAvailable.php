<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:51
 */

namespace Magento\FulfilReport\Test\Constraint\Dashboard\ContainerCarrier;

use Magento\FulfilReport\Test\Page\Adminhtml\ReportDashboard;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendButtonAndTitleIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint\ContainerCarrier
 */
class AssertBackendButtonAndTitleIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportDashboard $reportDashboard
     */
    public function processAssert(ReportDashboard $reportDashboard, $chartsTitleCarrier)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportDashboard->getContainerCarrier()->getHighChartsButton()->isVisible(),
            'On The Backend Page, the Grid Header High Charts Button Of the Fulfilment Report->Dashboard->Container Carrier was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitleCarrier .' '. $reportDashboard->getContainerCarrier()->getThirdHighChartsTitle()->getText(),
            $reportDashboard->getContainerCarrier()->getFirstHighChartsTitle()->getText().' '.$reportDashboard->getContainerCarrier()->getSecondHighChartsTitle()->getText().' '.$reportDashboard->getContainerCarrier()->getThirdHighChartsTitle()->getText(),
            'The charts title Of Container Carrier was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements in the Page Of the Fulfilment Report->Dashboard->Container Carrier was visible successfully.';
    }
}