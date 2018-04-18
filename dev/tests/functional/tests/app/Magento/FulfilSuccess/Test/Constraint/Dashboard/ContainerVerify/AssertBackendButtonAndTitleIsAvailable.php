<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:51
 */

namespace Magento\FulfilSuccess\Test\Constraint\Dashboard\ContainerVerify;

use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportDashboard;
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
    public function processAssert(ReportDashboard $reportDashboard, $chartsTitleVerify)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportDashboard->getContainerVerify()->getHighChartsButton()->isVisible(),
            'On The Backend Page, the Grid Header High Charts Button Of the Fulfilment Report->Dashboard->Container Verify Section was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitleVerify,
            $reportDashboard->getContainerVerify()->getHighChartsTitle()->getText(),
            'The charts title Of Container Verify was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements in the Page Of the Fulfilment Report->Dashboard-> at the Container Verify location was visible successfully.';
    }
}