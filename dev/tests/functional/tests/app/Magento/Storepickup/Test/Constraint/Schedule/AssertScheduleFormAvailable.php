<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 2:47 PM
 */

namespace Magento\Storepickup\Test\Constraint\Schedule;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleNew;

class AssertScheduleFormAvailable extends AbstractConstraint
{

    public function processAssert(ScheduleNew $scheduleNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $scheduleNew->getScheduleForm()->isVisible(),
            'Schedule form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $scheduleNew->getScheduleForm()->generalTitleIsVisible(),
            'Schedule general title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $scheduleNew->getScheduleForm()->scheduleNameFieldIsVisible(),
            'Schedule name field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Schedule form is available.';
    }
}