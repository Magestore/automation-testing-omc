<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 3:19 PM
 */

namespace Magento\Storepickup\Test\Constraint\Specialday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayNew;

/**
 * Class AssertSpecialdayFormAvailable
 * @package Magento\Storepickup\Test\Constraint\Specialday
 */
class AssertSpecialdayFormAvailable extends AbstractConstraint
{

    /**
     * @param SpecialdayNew $specialdayNew
     */
    public function processAssert(SpecialdayNew $specialdayNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->isVisible(),
            'Special day is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->generalTitleIsVisible(),
            'Special day general title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->specialDayNameFieldIsVisible(),
            'Special day name field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->dateStartFieldIsVisible(),
            'Date start field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->dateEndFieldIsVisible(),
            'Date end field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->openTimeFieldIsVisible(),
            'Open Time field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->closeTimeFieldIsVisible(),
            'Close Time field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->commentFieldIsVisible(),
            'Comment field is not visible.'
        );
        $specialdayNew->getSpecialdayForm()->openTab('stores');
        $specialdayNew->getSpecialdayForm()->waitOpenStoresTab();
        \PHPUnit_Framework_Assert::assertTrue(
            $specialdayNew->getSpecialdayForm()->storesGridIsVisible(),
            'Store grid is not visible.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Special day form is available.';
    }
}