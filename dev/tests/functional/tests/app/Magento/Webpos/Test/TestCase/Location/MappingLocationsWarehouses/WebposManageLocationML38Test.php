<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11/05/2018
 * Time: 14:20
 */

namespace Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses;

use Magento\InventorySuccess\Test\Fixture\Warehouse;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Mapping locations - Warehouses
 * Testcase: ML38 - Check [Remove] action
 *
 * Precondition
 * - Exist at least 2 records on the grid of [mapping locations -warehouses] page
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Mapping Locations - Warehouses] button
 * - Click on [Remove] action on the record
 * - Click on [Cancel] button
 * - Click on [Mapping Locations - Warehouses] again
 *
 * Acceptance
 * - That record will be removed from the grid
 * - back to Location page
 * - The removed record still shows on the grid
 *
 * Class WebposManageLocationML38Test
 * @package Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses
 */
class WebposManageLocationML38Test extends Injectable
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

    public function test(Location $location, Warehouse $warehouse1)
    {
        /*Precondition*/
        $location->persist();
        $warehouse1->persist();
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
        $this->mappingLocationIndex->getMappingLocationGrid()->mappingWarehouse($location->getDisplayName(), $warehouse1->getWarehouseName());
        sleep(2);
        $this->mappingLocationIndex->getFormPageActions()->save();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->mappingLocationIndex->getMappingLocationGrid()->removeMappingByLocation($location->getDisplayName());
        sleep(1);
        $this->mappingLocationIndex->getFormPageActions()->cancel();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitLoader();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitLoader();
        return [
            'location' => $location,
        ];
    }
}

