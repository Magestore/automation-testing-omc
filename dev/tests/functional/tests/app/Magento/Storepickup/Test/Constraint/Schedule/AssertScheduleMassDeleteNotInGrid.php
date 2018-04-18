<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:24 PM
 */

namespace Magento\Storepickup\Test\Constraint\Schedule;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupSchedule;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;

class AssertScheduleMassDeleteNotInGrid extends AbstractConstraint
{
    /**
     *
     * @param ScheduleIndex $scheduleIndex
     * @param int $schedulesQtyToDelete
     * @param StorepickupSchedule[] $schedules
     * @return void
     */
    public function processAssert(
        ScheduleIndex $scheduleIndex,
        $schedulesQtyToDelete,
        $schedules
    ) {
        for ($i = 0; $i < $schedulesQtyToDelete; $i++) {
            \PHPUnit_Framework_Assert::assertFalse(
                $scheduleIndex->getScheduleGrid()->isRowVisible(['name' => $schedules[$i]->getScheduleName()]),
                'Schedule with name ' . $schedules[$i]->getScheduleName() . 'is present in Schedule grid.'
            );
        }
    }

    /**
     * Success message if Schedule not in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Deleted schedules are absent in Schedule grid.';
    }
}