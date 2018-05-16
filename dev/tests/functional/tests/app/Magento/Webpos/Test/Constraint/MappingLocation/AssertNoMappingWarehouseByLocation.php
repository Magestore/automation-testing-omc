<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/11/18
 * Time: 3:10 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertNoMappingWarehouseByLocation extends AbstractConstraint
{
    public function processAssert(MappingLocationIndex $mappingLocationIndex, Location $location){
        \PHPUnit_Framework_Assert::assertFalse(
            $mappingLocationIndex->getMappingLocationGrid()->getRowByLocation($location->getDisplayName())->isVisible(),
            'Location is still mapped to a warehouse'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Location could not mapping any warehouse';
    }
}