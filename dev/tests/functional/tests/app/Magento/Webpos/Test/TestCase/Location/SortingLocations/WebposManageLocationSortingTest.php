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
 * Class WebposManageLocationSortingTest
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationSortingTest extends Injectable
{
    /**
     * Mapping Location Index page
     *
     * @var MappingLocationIndex
     */
    protected $mappingLocationIndex;

    /**
     * @param MappingLocationIndex $mappingLocationIndex
     */
    public function __inject(
        MappingLocationIndex $mappingLocationIndex
    ) {
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
        if($this->mappingLocationIndex->getLocationModal()->isClearButtonVisible()){
            $this->mappingLocationIndex->getLocationModal()->getClearFilterButton();
        }
        $sortingResults = [];
        $this->mappingLocationIndex->getLocationModal()->sortByColumn($columnsForSorting);
        sleep(2);
        $sortingResults[$columnsForSorting]['firstIdAfterFirstSoring'] = (string) $this->mappingLocationIndex->getLocationModal()->getFirstItemId();
        $this->mappingLocationIndex->getLocationModal()->sortByColumn($columnsForSorting);
        sleep(2);
        $sortingResults[$columnsForSorting]['firstIdAfterSecondSoring'] = $this->mappingLocationIndex->getLocationModal()->getFirstItemId();
        return ['sortingResults' => $sortingResults];
    }
}