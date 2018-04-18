<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 27/11/2017
 * Time: 16:00
 */

namespace Magento\FulfilSuccess\Test\Constraint\OrderFulfilment;

use Magento\FulfilReport\Test\Page\Adminhtml\ReportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendButtonIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint
 */
class AssertBackendButtonIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportIndex $reportIndex
     */
    public function processAssert(ReportIndex $reportIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getVerifyButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Verify Order Of the Fulfilment Fulfilment Extension was not  not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getPrepareButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Prepare Of the Fulfilment Extension was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getPickItemButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Pick Item Of the Fulfilment Extension was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getPackItemButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Pack Item Of the Fulfilment Extension was not  visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getPageWrapper()->getDeliveryPackageButton()->isVisible(),
            'On The Backend Page, the Grid Header Button Delivery Package Order Of the Fulfilment Extension was not  visible.'
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