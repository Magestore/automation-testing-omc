<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 1:52 PM
 */

namespace Magento\Storepickup\Test\Constraint\Schedule;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleNew;

class AssertScheduleFormRequireFieldsVisible extends AbstractConstraint
{
    public function processAssert(ScheduleNew $scheduleNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $scheduleNew->getScheduleForm()->scheduleNameRequireErrorIsVisible(),
            'Schedule name require error is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Require error is visible.';
    }
}