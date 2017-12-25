<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 8:56 AM
 */

namespace Magento\Storepickup\Test\TestCase\Holiday;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Fixture\StorepickupHoliday;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayNew;

/**
 * Steps:
 * 1. Login to the backend.
 * 2. Navigate to Store Pickup > Manage Holiday.
 * 3. Start to Add New Holiday .
 * 4. Fill in data according to data set.
 * 5. Save Holiday.
 * 6. Perform appropriate assertions.
 *
 */
class CreateStorePickupHolidayEntityTest extends Injectable
{
    /**
     * @var HolidayIndex
     */
    protected $holidayIndex;

    /**
     * @var HolidayNew
     */
    protected $holidayNew;

    /**
     * @param HolidayIndex $holidayIndex
     * @param HolidayNew $holidayNew
     */
    public function __inject(HolidayIndex $holidayIndex, HolidayNew $holidayNew)
    {
        $this->holidayIndex = $holidayIndex;
        $this->holidayNew = $holidayNew;
    }

    public function test(StorepickupHoliday $storepickupHoliday)
    {
        $this->holidayIndex->open();
        $this->holidayIndex->getHolidayGridPageActions()->clickActionButton('add');
        $this->holidayNew->getHolidayForm()->fill($storepickupHoliday);
        $this->holidayNew->getHolidayFormPageActions()->save();
    }
}