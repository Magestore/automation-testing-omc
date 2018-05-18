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
 * Testcase: ML37 - Change warehouse on the grid
 *
 * Precondition
 * - Exist at least 2 records on the grid of [mapping locations -warehouses] page
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Mapping Locations - Warehouses] button
 * - Change the warehouse of 1 record to another warehouse that is assigning to the another location
 * - Click [Save] button
 *
 * Acceptance
 * - The grid will be updated data:
 * - Data will be saved successfully and show message "The mapping warehouses - locations have been saved."
 *
 * Class WebposManageLocationML37Test
 * @package Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses
 */
class WebposManageLocationML37Test extends Injectable
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

    public function test(Location $location, Warehouse $warehouse1, Warehouse $warehouse2)
    {
        /*Precondition*/
        $location->persist();
        $warehouse1->persist();
        $warehouse2->persist();
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitLoader();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        $filters= [
            [
                'display_name' => $location->getDisplayName()
            ]
        ];
        $this->mappingLocationIndex->getLocationModal()->search($filters[0]);
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        $this->mappingLocationIndex->getLocationModal()->selectItems($filters);
        $this->mappingLocationIndex->getLocationModal()->getAddButton()->click();
        $this->mappingLocationIndex->getLocationModal()->waitClose();
        $this->mappingLocationIndex->getMappingLocationGrid()->mappingWarehouse($location->getDisplayName(), $warehouse1->getWarehouseName());
        sleep(2);
        $this->mappingLocationIndex->getFormPageActions()->save();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();

//        /*Steps*/
        sleep(2);
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->locationIndex->open();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->mappingLocationIndex->getMappingLocationGrid()->mappingWarehouse($location->getDisplayName(), $warehouse2->getWarehouseName());
        sleep(1);
        $this->mappingLocationIndex->getFormPageActions()->save();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitLoader();
        return [
            'location' => $location,
            'warehouse' => $warehouse2
        ];
    }
}

