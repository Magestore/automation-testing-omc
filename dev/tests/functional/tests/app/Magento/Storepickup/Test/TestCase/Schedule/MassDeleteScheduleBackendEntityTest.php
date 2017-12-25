<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:04 PM
 */

namespace Magento\Storepickup\Test\TestCase\Schedule;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;

/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create X holidays
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Store Pickup > Manage Holiday
 * 3. Select N holidays from preconditions
 * 4. Select in dropdown "Delete"
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */
class MassDeleteScheduleBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var ScheduleIndex
     */
    protected $scheduleIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param ScheduleIndex $tagIndex
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        ScheduleIndex $scheduleIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->scheduleIndex = $scheduleIndex;
        $scheduleIndex->open();
        $scheduleIndex->getScheduleGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test($schedulesQty, $schedulesQtyToDelete)
    {
        $schedules = $this->createSchedules($schedulesQty);
        $deleteSchedules = [];
        for ($i = 0; $i < $schedulesQtyToDelete; $i++) {
            $deleteSchedules[] = ['name' => $schedules[$i]->getScheduleName()];
        }
        $this->scheduleIndex->open();
        $this->scheduleIndex->getScheduleGrid()->massaction($deleteSchedules, 'Delete', true);

        return ['schedules' => $schedules];
    }

    public function createSchedules($schedulesQty)
    {
        $schedules = [];
        for ($i = 0; $i < $schedulesQty; $i++) {
            $schedule = $this->fixtureFactory->createByCode('storepickupSchedule', ['dataset' => 'default1']);
            $schedule->persist();
            $schedules[] = $schedule;
        }
        return $schedules;
    }
}