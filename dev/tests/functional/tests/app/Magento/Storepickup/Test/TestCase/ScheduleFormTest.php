<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:33 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;

class ScheduleFormTest extends Injectable
{
    /**
     * @var ScheduleIndex
     */
    public $scheduleIndex;

    /**
     * @param ScheduleIndex $scheduleIndex
     */
    public function __inject(ScheduleIndex $scheduleIndex)
    {
        $this->scheduleIndex = $scheduleIndex;
    }

    public function test($button)
    {
        $this->scheduleIndex->open();
        $this->scheduleIndex->getScheduleGridPageActions()->clickActionButton($button);
    }

}