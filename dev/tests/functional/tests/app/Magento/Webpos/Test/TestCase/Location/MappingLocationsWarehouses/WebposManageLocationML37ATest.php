<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11/05/2018
 * Time: 14:20
 */

namespace Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Mapping locations - Warehouses
 * Testcase: ML37-1 - Change warehouse on the grid
 *
 * Precondition
 * - Exist at least 2 records on the grid of [mapping locations -warehouses] page
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Mapping Locations - Warehouses] button
 * - Change the warehouse of 1 record to [Create a new warehouse]
 * - Click [Save] button
 *
 * Acceptance
 * - A new warehouse will be created and assigned to that location
 *
 * Class WebposManageLocationML37ATest
 * @package Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses
 */
class WebposManageLocationML37ATest extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * @var MappingLocationIndex
     */
    private $mappingLocationIndex;


    /**
     * @param LocationIndex $locationIndex
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function __inject(
        LocationIndex $locationIndex,
        MappingLocationIndex $mappingLocationIndex
    )
    {
        $this->locationIndex = $locationIndex;
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    public function test(Location $location)
    {
        /*Precondition*/
        $location->persist();
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitLoader();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(2);
        $this->mappingLocationIndex->getLocationModal()->searchAndSelect([
            'display_name' => $location->getDisplayName()
        ]);
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        $this->mappingLocationIndex->getLocationModal()->getAddButton()->click();
        $this->mappingLocationIndex->getLocationModal()->waitClose();
        $this->mappingLocationIndex->getMappingLocationGrid()->mappingWarehouse($location->getDisplayName(), 'Create a new Warehouse');
        sleep(2);
        $this->mappingLocationIndex->getFormPageActions()->save();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
    }
}

