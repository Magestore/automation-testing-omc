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

/**
 * Class AssertScheduleFormAvailable
 * @package Magento\Storepickup\Test\Constraint\Schedule
 */
class AssertScheduleFormAvailable extends AbstractConstraint
{

    /**
     * @param ScheduleNew $scheduleNew
     */
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
        $scheduleTime = $scheduleNew->getScheduleForm()->getScheduleTime();
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('monday', $selector),
                sprintf($field, 'monday') . ' field is not visible.'
            );
        }
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('tuesday', $selector),
                sprintf($field, 'tuesday') . ' field is not visible.'
            );
        }
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('wednesday', $selector),
                sprintf($field, 'wednesday') . ' field is not visible.'
            );
        }
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('thursday', $selector),
                sprintf($field, 'thursday') . ' field is not visible.'
            );
        }
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('friday', $selector),
                sprintf($field, 'friday') . ' field is not visible.'
            );
        }
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('saturday', $selector),
                sprintf($field, 'saturday') . ' field is not visible.'
            );
        }
        foreach ($scheduleTime as $field => $selector) {
            \PHPUnit_Framework_Assert::assertTrue(
                $scheduleNew->getScheduleForm()->scheduleFieldIsVisible('sunday', $selector),
                sprintf($field, 'sunday') . ' field is not visible.'
            );
        }
        $scheduleNew->getScheduleForm()->openTab('stores');
        $scheduleNew->getScheduleForm()->waitOpenStoresTab();
        \PHPUnit_Framework_Assert::assertTrue(
            $scheduleNew->getScheduleForm()->storesGridIsVisisble(),
            'Stores grid is not visible.'
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