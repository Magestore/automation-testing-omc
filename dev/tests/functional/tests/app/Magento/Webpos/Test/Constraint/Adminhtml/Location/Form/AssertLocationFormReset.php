<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/10/18
 * Time: 8:45 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

class AssertLocationFormReset extends AbstractConstraint
{
    public function processAssert(LocationNews $locationNews, Location $location)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $location->getDisplayName(),
            $locationNews->getLocationsForm()->getField('page_display_name')->getValue(),
            'Field Display Name could not reset'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $location->getAddress(),
            $locationNews->getLocationsForm()->getField('page_address')->getValue(),
            'Field Address could not reset'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $location->getDescription(),
            $locationNews->getLocationsForm()->getField('page_description')->getValue(),
            'Field Description could not reset'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Form location is reseted';
    }
}