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
 * Testcase ML47
 *
 * Precondition:
 * Exist at least 2 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on Filter button
 * 4. Input data into all fields that match one or some records
 * 5. Click on [Filters] button
 *
 * Acceptance Criteria
 * 4.
 * - Close Filter form
 * - The grid shows all records
 *
 * Class WebposManageLocationML47Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML47Test extends Injectable
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
    )
    {
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    /**
     * @param Location $initialLocation
     * @param Location $location
     * @return array
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
        sleep(3);
        $this->mappingLocationIndex->getLocationModal()->search(['display_name' => $location->getDisplayName()]);
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(2);
        return [
            'location' => $location
        ];
    }
}