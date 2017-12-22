<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 3:14 PM
 */

namespace Magento\Storepickup\Test\Constraint\Specialday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayNew;

class AssertSpecialdayFormRequireFieldVisible extends AbstractConstraint
{
    public function processAssert(SpecialdayNew $specialdayNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->specialdayNameFieldRequireErrorIsVisible(),
            'Specialday Name require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->dateStartFieldRequireErrorIsVisible(),
            'Date Start require error is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->dateEndFieldRequireErrorIsVisible(),
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