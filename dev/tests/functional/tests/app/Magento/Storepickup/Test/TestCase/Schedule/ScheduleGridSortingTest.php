<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 5:36 PM
 */

namespace Magento\Storepickup\Test\TestCase\Schedule;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Ui\Test\TestCase\GridSortingTest;

/**
 * Precondition:
 * 1. Create items
 *
 * Steps:
 * 1. Navigate to backend.
 * 2. Go to grid page Store Pickup > Manage Schedule.
 * 3. Sort grid using provided columns
 * 5. Perform Asserts
 *
 */
class ScheduleGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $schedule = $fixtureFactory->createByCode('storepickupSchedule', ['dataset' => 'scheduleclose']);
        $schedule->persist();
    }
}