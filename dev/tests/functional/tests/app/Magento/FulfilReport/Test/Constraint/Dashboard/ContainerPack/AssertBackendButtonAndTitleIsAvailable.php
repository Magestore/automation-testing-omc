<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:51
 */

namespace Magento\FulfilReport\Test\Constraint\Dashboard\ContainerPack;

use Magento\FulfilReport\Test\Page\Adminhtml\ReportDashboard;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendButtonAndTitleIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint\ContainerPack
 */
class AssertBackendButtonAndTitleIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportDashboard $reportDashboard
     */
    public function processAssert(ReportDashboard $reportDashboard, $chartsTitlePack)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportDashboard->getContainerPack()->getHighChartsButton()->isVisible(),
            'On The Backend Page, the Grid Header High Charts Button Of the Fulfilment Report->Dashboard->Container Pack Section was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitlePack,
            $reportDashboard->getContainerPack()->getHighChartsTitle()->getText(),
            'The charts title of container pack location was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements in the Page Of the Fulfilment Report->Dashboard-> at the Container Pack location was visible successfully.';
    }
}