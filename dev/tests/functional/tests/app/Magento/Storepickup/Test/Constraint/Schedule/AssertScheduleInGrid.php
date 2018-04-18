<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 1:36 PM
 */

namespace Magento\Storepickup\Test\Constraint\Schedule;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupSchedule;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;

class AssertScheduleInGrid extends AbstractConstraint
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    private $filter;

    public function processAssert(
        StorepickupSchedule $storepickupSchedule,
        ScheduleIndex $scheduleIndex
    ) {
        $scheduleIndex->open();
        $data = $storepickupSchedule->getData();
        $this->filter = ['name' => $data['schedule_name']];
        $scheduleIndex->getScheduleGrid()->search($this->filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $scheduleIndex->getScheduleGrid()->isRowVisible($this->filter, false, false),
            'Schedule is absent in Schedule grid'
        );

//        \PHPUnit_Framework_Assert::assertEquals(
//            count($scheduleIndex->getScheduleGrid()->getAllIds()),
//            1,
//            'There is more than one schedule founded'
//        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Schedule is present in grid.';
    }
}