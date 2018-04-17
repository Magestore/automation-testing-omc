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
    ) {
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
        $this->mappingLocationIndex->getLocationModal()->searchAndSelect(['display_name' => $location->getDisplayName()]);
        $this->mappingLocationIndex->getLocationModal()->getAddButton()->click();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
        $this->assertLocationShownOnGrid->processAssert($this->mappingLocationIndex);
        $this->mappingLocationIndex->getPageActions()->save();
        sleep(1);
    }
}