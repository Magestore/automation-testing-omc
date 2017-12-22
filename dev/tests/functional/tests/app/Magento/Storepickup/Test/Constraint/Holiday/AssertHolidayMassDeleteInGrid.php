<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:49 PM
 */

namespace Magento\Storepickup\Test\Constraint\Holiday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupHoliday;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;

class AssertHolidayMassDeleteInGrid extends AbstractConstraint
{
    /**
     *
     * @param HolidayIndex $holidayIndex,
     * @param AssertHolidayInGrid $assertHolidayInGrid
     * @param int $holidaysQtyToDelete
     * @param StorepickupHoliday[] $holidays
     * @return void
     */
    public function processAssert(
        HolidayIndex $holidayIndex,
        AssertHolidayInGrid $assertHolidayInGrid,
        $holidaysQtyToDelete,
        $holidays
    ) {
        $holidays = array_slice($holidays, $holidaysQtyToDelete);
        foreach ($holidays as $holiday) {
            $assertHolidayInGrid->processAssert($holiday, $holidayIndex);
        }
    }

    /**
     * Success message if Holiday in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Holiday are present in Holiday grid.';
    }
}