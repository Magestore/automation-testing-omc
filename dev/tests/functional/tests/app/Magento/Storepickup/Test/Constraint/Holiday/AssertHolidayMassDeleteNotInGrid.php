<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:46 PM
 */

namespace Magento\Storepickup\Test\Constraint\Holiday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupHoliday;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;

class AssertHolidayMassDeleteNotInGrid extends AbstractConstraint
{
    /**
     *
     * @param HolidayIndex $holidayIndex
     * @param int $holidaysQtyToDelete
     * @param StorepickupHoliday[] $holidays
     * @return void
     */
    public function processAssert(
        HolidayIndex $holidayIndex,
        $holidaysQtyToDelete,
        $holidays
    ) {
        for ($i = 0; $i < $holidaysQtyToDelete; $i++) {
            \PHPUnit_Framework_Assert::assertFalse(
                $holidayIndex->getHolidayGrid()->isRowVisible(['name' => $holidays[$i]->getHolidayName()]),
                'Holiday with name ' . $holidays[$i]->getHolidayName() . 'is present in Holiday grid.'
            );
        }
    }

    /**
     * Success message if Holiday not in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Deleted holidays are absent in Holiday grid.';
    }
}