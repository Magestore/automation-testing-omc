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
            'On The Backend Page, the Grid Header Button Verify Order Of the Extension was visible.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $chartsTitleVerify,
            $reportDashboard->getContainerVerify()->getHighChartsTitle()->getText(),
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