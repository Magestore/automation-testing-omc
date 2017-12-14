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