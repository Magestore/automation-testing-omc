<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:28 PM
 */

namespace Magento\Storepickup\Test\Constraint\Schedule;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupSchedule;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;

class AssertScheduleMassDeleteInGrid extends AbstractConstraint
{
    /**
     *
     * @param ScheduleIndex $scheduleIndex,
     * @param AssertScheduleInGrid $assertScheduleInGrid
     * @param int $schedulesQtyToDelete
     * @param StorepickupSchedule[] $schedules
     * @return void
     */
    public function processAssert(
        ScheduleIndex $scheduleIndex,
        AssertScheduleInGrid $assertScheduleInGrid,
        $schedulesQtyToDelete,
        $schedules
    ) {
        $schedules = array_slice($schedules, $schedulesQtyToDelete);
        foreach ($schedules as $schedule) {
            $assertScheduleInGrid->processAssert($schedule, $scheduleIndex);
        }
    }

    /**
     * Success message if Schedule in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Schedules are present in Schedule grid.';
    }
}