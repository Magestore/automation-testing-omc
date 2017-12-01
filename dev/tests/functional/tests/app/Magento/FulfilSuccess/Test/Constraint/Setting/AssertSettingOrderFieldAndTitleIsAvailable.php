<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 11/29/2017
 * Time: 8:30 AM
 */
namespace Magento\FulfilSuccess\Test\Constraint\Setting;


use Magento\FulfilSuccess\Test\Page\Adminhtml\ReportIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackendFieldAndTitleIsAvailable
 * @package Magento\FulfilSuccess\Test\Constraint\Setting
 */
class AssertSettingOrderFieldAndTitleIsAvailable extends AbstractConstraint
{
    /**
     * @param ReportIndex $reportIndex
     */
    public function processAssert(ReportIndex $reportIndex, $titleOrderSection)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $titleOrderSection,
            $reportIndex->getContainer()->getTitleOrderSection()->getText(),
            'Title Order Section on the ORDER CONFIGURATION fulfilment was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $reportIndex->getContainer()->getFirstFieldOrder()->isVisible(),
            'On The Backend Page, the Field Section Verify ORDER CONFIGURATION Setting Of the Extension was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements include: fields and titles in the ORDER configuration Of the Fulfilment Extension Fulfilment was visible successfully.';
    }
}