<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/7/2018
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\TestCase\Location\FilterLocations;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Webpos\Test\Fixture\Location;

/**
 * Check [Choose locations] page
 * Testcase ML45
 * Precondition:
 * Exist at least 2 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on Filter button
 * 4. Input data into some fields that dont match any record
 * 5. Click on [Apply Filters] button
 *
 * Acceptance Criteria
 * 5.
 * - Close Filter form
 * - Show message: "We couldn't find any records." on the Grid
 *
 *
 * Class WebposManageLocationML45Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML45Test extends Injectable
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
     */
    public function test(
        Location $initialLocation,
        Location $location
    )
    {
        // Steps
        $initialLocation->persist();
        $location->persist();
        $this->mappingLocationIndex->open();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(2);
        if ($this->mappingLocationIndex->getLocationModal()->isClearButtonVisible()) {
            $this->mappingLocationIndex->getLocationModal()->getClearFilterButton()->click();
        }
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(3);
        $this->mappingLocationIndex->getLocationModal()->search(['display_name' => 'Magestore1@3']);
        sleep(1);
    }
}