<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/11/18
 * Time: 2:10 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;


use Magento\InventorySuccess\Test\Fixture\Warehouse;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

class AssertMappingLocationWarehouseCorrect extends AbstractConstraint
{
    public function processAssert(MappingLocationIndex $mappingLocationIndex, Location $location
    , Warehouse $warehouse)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $mappingLocationIndex->getMappingLocationGrid()->checkWarehouseByLocation($location->getDisplayName(),
                $warehouse->getWarehouseName())->isVisible(),
            'Warehouse could not respectively location'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Location is mapped respect warehouse';
    }
}