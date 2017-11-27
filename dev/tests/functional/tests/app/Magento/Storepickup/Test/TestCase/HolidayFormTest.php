<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:44 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;

class HolidayFormTest extends Injectable
{
    /**
     * @var HolidayIndex
     */
    protected $holidayIndex;

    /**
     * @param HolidayIndex $holidayIndex
     */
    public function __inject(HolidayIndex $holidayIndex)
    {
        $this->holidayIndex = $holidayIndex;
    }

    public function test($button)
    {
        $this->holidayIndex->open();
        $this->holidayIndex->getHolidayGridPageActions()->clickActionButton($button);
    }
}