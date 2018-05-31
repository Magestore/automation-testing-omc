<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 8:15 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\SortingLocations;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Webpos\Test\Fixture\Location;

/**
 * Check [Choose locations] page
 * Testcase ML48 - Check sorting by ID column
 *
 * Precondition:
 * Precondition:
 * Exist at least 2 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locationss
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on title of ID column
 * 4. Click again
 *
 * Acceptance Criteria
 * 4.
 * - Close Filter form
 * - The grid shows all records
 *
 * Class WebposManageLocationSortingTest
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationSortingTest extends Injectable
{
    /**
     * Mapping Location Index page
     *
     * @var MappingLocationIndex $mappingLocationIndex
     */
    protected $mappingLocationIndex;

    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function __inject(
        MappingLocationIndex $mappingLocationIndex
    )
    {
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    /**
     * @param Location $initialLocation
     * @param Location $location
     * @param $columnsForSorting
     * @return array
     */
    public function test(
        Location $initialLocation,
        Location $location,
        $columnsForSorting
    )
    {
        // Steps
        $initialLocation->persist();
        $location->persist();
        $this->mappingLocationIndex->open();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        sleep(1);
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        $this->mappingLocationIndex->getLocationModal()->resetFilter();
        sleep(2);
        if ($this->mappingLocationIndex->getLocationModal()->isClearButtonVisible()) {
            $this->mappingLocationIndex->getLocationModal()->getClearFilterButton();
        }
        $sortingResults = [];
        $this->mappingLocationIndex->getLocationModal()->sortByColumn($columnsForSorting);
        sleep(2);
        $sortingResults[$columnsForSorting]['firstIdAfterFirstSoring'] = (string)$this->mappingLocationIndex->getLocationModal()->getFirstItemId();
        $this->mappingLocationIndex->getLocationModal()->sortByColumn($columnsForSorting);
        sleep(2);
        $sortingResults[$columnsForSorting]['firstIdAfterSecondSoring'] = $this->mappingLocationIndex->getLocationModal()->getFirstItemId();
        return ['sortingResults' => $sortingResults];
    }
}