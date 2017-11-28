<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 14:51
 */

namespace Magento\FulfilSuccess\Test\Constraint\Dashboard\ContainerPack;

use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportDashboard;
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
            'On The Backend Page, the Grid Header Button Verify Order Of the Extension was visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitlePack,
            $reportDashboard->getContainerPack()->getHighChartsTitle()->getText(),
            'Create Customer Address successfully.'
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