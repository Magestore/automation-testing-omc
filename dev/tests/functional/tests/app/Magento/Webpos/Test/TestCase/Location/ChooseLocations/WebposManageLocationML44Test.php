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
use Magento\Webpos\Test\Constraint\MappingLocation\AssertCheckGUIFilterOnModalPage;

/**
 * Check [Choose locations] page
 * TestCase ML42 - Check filter function
 *
 *
 * Precondition
 *  Exist at least 2 location that doesnt link to any warehouse
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on Filter button
 * 4. Click on [Cancel] button
 *
 * Acceptance Criteria
 * 3. Show Filters form including:
 * 4 fields: ID, Display name, Address, Description
 * 2 buttons: Cancel, Apply filters*
 * 4. Close Filters form
 *
 *
 * Class WebposManageLocationML44Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML44Test extends Injectable
{
    /**
     * Mapping Location Index page
     *
     * @var MappingLocationIndex
     */
    protected $mappingLocationIndex;

    /**
     * @var AssertCheckGUIFilterOnModalPage
     */
    protected $assertCheckGUIFilterOnModalPage;

    /**
     * @param MappingLocationIndex $mappingLocationIndex
     * @param AssertCheckGUIFilterOnModalPage $assertCheckGUIFilterOnModalPage
     */
    public function __inject(
        MappingLocationIndex $mappingLocationIndex,
        AssertCheckGUIFilterOnModalPage $assertCheckGUIFilterOnModalPage
    )
    {
        $this->mappingLocationIndex = $mappingLocationIndex;
        $this->assertCheckGUIFilterOnModalPage = $assertCheckGUIFilterOnModalPage;
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
        sleep(2);
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(5);
        $this->mappingLocationIndex->getLocationModal()->openFilterBlock();
        $this->assertCheckGUIFilterOnModalPage->processAssert($this->mappingLocationIndex);
        $this->mappingLocationIndex->getLocationModal()->getCancelButtonFilter()->click();
        sleep(3);
    }
}