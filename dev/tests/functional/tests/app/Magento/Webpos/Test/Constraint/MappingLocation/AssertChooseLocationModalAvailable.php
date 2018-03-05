<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/5/2018
 * Time: 4:00 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertChooseLocationModalAvailable
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertChooseLocationModalAvailable extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $indexPage
     */
    public function processAssert(MappingLocationIndex $indexPage)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $indexPage->getLocationModal()->getCancelButton()->isVisible(),
            'Cancel button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $indexPage->getLocationModal()->getAddButton()->isVisible(),
            'Add button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $indexPage->getLocationModal()->getDataGridHeader()->isVisible(),
            'Data Grid Header is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $indexPage->getLocationModal()->getDataGridWrap()->isVisible(),
            'Data Grid Wrap is not visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Choose Locations Modal is correctly.';
    }
}