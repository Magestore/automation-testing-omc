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

/**
 * Steps:
 * 1. LoginTest to the backend.
 * 2. Navigate to Store Pickup > Manage Holiday.
 * 3. Click to Add New Holiday.
 * 4. Perform appropriate assertions.
 *
 */
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

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->holidayIndex->open();
        $this->holidayIndex->getHolidayGridPageActions()->clickActionButton($button);
    }
}