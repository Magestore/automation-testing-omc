<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 3:05 PM
 */

namespace Magento\Storepickup\Test\Constraint\Holiday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayNew;

class AssertHolidayFormAvailable extends AbstractConstraint
{

    public function processAssert(HolidayNew $holidayNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $holidayNew->getHolidayForm()->isVisible(),
            'Holiday form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $holidayNew->getHolidayForm()->generalTitleIsVisible(),
            'Holiday general title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $holidayNew->getHolidayForm()->holidayNameFieldIsVisible(),
            'Holiday name field is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Holiday form is available.';
    }
}