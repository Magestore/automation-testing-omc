<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 9:11 AM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertLocationShownOnGrid
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertLocationShownOnGrid extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function processAssert(MappingLocationIndex $mappingLocationIndex)
    {
        // Show on "Mapping Locations - Warehouses" page
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getLocationModal()->isFirstRowVisible(),
            'Location not shown on the grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Location shown on the grid.';
    }
}