<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/11/18
 * Time: 3:44 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertMappingWarehouseByLocation extends AbstractConstraint
{

    public function processAssert(MappingLocationIndex $mappingLocationIndex, Location $location)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getMappingLocationGrid()->getRowByLocation($location->getDisplayName())->isVisible(),
            'Location ' . $location->getDisplayName() . ' is n\'t mapped to any warehouse'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Exits mapping Location Warehouse";
    }
}