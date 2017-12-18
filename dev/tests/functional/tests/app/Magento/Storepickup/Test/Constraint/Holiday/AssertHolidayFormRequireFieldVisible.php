<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 2:31 PM
 */

namespace Magento\Storepickup\Test\Constraint\Holiday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayNew;

class AssertHolidayFormRequireFieldVisible extends AbstractConstraint
{
    public function processAssert(HolidayNew $holidayNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $holidayNew->getHolidayForm()->holidayNameFieldRequireErrorIsVisible(),
            'Holiday Name require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $holidayNew->getHolidayForm()->dateStartFieldRequireErrorIsVisible(),
            'Date Start require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $holidayNew->getHolidayForm()->dateEndFieldRequireErrorIsVisible(),
            'Date End require error is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Require error is visible.';
    }
}