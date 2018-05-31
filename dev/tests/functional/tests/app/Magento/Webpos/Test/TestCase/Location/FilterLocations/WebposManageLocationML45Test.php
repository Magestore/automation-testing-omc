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
    ) {
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
        if($this->mappingLocationIndex->getLocationModal()->isClearButtonVisible()){
            $this->mappingLocationIndex->getLocationModal()->getClearFilterButton()->click();
        }
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(3);
        $this->mappingLocationIndex->getLocationModal()->search(['display_name' => 'Magestore1@3']);
        sleep(1);
    }
}