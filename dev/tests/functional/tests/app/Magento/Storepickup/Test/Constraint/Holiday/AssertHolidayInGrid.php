<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 2:18 PM
 */

namespace Magento\Storepickup\Test\Constraint\Holiday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupHoliday;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;

class AssertHolidayInGrid extends AbstractConstraint
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    private $filter;

    public function processAssert(
        StorepickupHoliday $storepickupHoliday,
        HolidayIndex $holidayIndex
    ) {
        $holidayIndex->open();
        $data = $storepickupHoliday->getData();
        $this->filter = ['name' => $data['holiday_name']];
        $holidayIndex->getHolidayGrid()->search($this->filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $holidayIndex->getHolidayGrid()->isRowVisible($this->filter, false, false),
            'Holiday is absent in Holiday grid'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            count($holidayIndex->getHolidayGrid()->getAllIds()),
            1,
            'There is more than one tag founded'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Holiday is present in grid.';
    }
}