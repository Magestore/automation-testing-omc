<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 8:24 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\ChooseLocations;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Constraint\MappingLocation\AssertLocationShownOnGrid;


/**
 *  Check [Choose locations] page
 * TestCase ML43 - Check [Save] button with selecting location
 *
 *
 * Precondition
 * Exist at least 1 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Select a location from the grid
 * 4. Click on [Save] button
 * 5. Click on [Save] button on [Mapping locations- warehouses] page
 *
 * Acceptance Criteria
 * 4. The selected location will be shown on the grid of [Mapping location -warehouse] page
 * 5. A new warehouse will be created and assigned to that location
 *
 * Class WebposManageLocationML43Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML43Test extends Injectable
{
    /**
     * Mapping Location Index page
     *
     * @var MappingLocationIndex
     */
    protected $mappingLocationIndex;

    /**
     * @var AssertLocationShownOnGrid
     */
    protected $assertLocationShownOnGrid;

    /**
     * @param MappingLocationIndex $mappingLocationIndex
     * @param AssertLocationShownOnGrid $assertLocationShownOnGrid
     */
    public function __inject(
        MappingLocationIndex $mappingLocationIndex,
        AssertLocationShownOnGrid $assertLocationShownOnGrid
    )
    {
        $this->mappingLocationIndex = $mappingLocationIndex;
        $this->assertLocationShownOnGrid = $assertLocationShownOnGrid;
    }

    /**
     * @param Location $location
     * @throws \Exception
     */
    public function test(
        Location $location
    )
    {
        // Steps
        $location->persist();
        $this->mappingLocationIndex->open();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(2);
        if ($this->mappingLocationIndex->getLocationModal()->isClearButtonVisible()) {
            $this->mappingLocationIndex->getLocationModal()->getClearFilterButton()->click();
        }
        sleep(3);
        $this->mappingLocationIndex->getLocationModal()->search(['display_name' => $location->getDisplayName()]);
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->assertLocationShownOnGrid->processAssert($this->mappingLocationIndex);
        $this->mappingLocationIndex->getLocationModal()->getAddButton()->click();
        sleep(2);
        $this->mappingLocationIndex->getFormPageActions()->save();
        sleep(2);
    }
}