<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 1:36 PM
 */

namespace Magento\Storepickup\Test\TestCase\Schedule;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Fixture\StorepickupSchedule;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleNew;

/**
 * Steps:
 * 1. Login to the backend.
 * 2. Navigate to Store Pickup > Manage Schedule.
 * 3. Start to Add New Schedule .
 * 4. Fill in data according to data set.
 * 5. Save Schedule.
 * 6. Perform appropriate assertions.
 *
 */
class CreateStorePickupScheduleEntityTest extends Injectable
{
    /**
     * @var ScheduleIndex
     */
    protected $scheduleIndex;

    /**
     * @var ScheduleNew
     */
    protected $scheduleNew;

    /**
     * @param ScheduleIndex $scheduleIndex
     * @param ScheduleNew $scheduleNew
     */
    public function __inject(ScheduleIndex $scheduleIndex, ScheduleNew $scheduleNew)
    {
        $this->scheduleIndex = $scheduleIndex;
        $this->scheduleNew = $scheduleNew;
    }

    public function test(StorepickupSchedule $storepickupSchedule)
    {
        $this->scheduleIndex->open();
        $this->scheduleIndex->getScheduleGridPageActions()->clickActionButton('add');
        $this->scheduleNew->getScheduleForm()->fill($storepickupSchedule);
        $this->scheduleNew->getScheduleFormPageActions()->save();
    }
}