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
 * Class WebposManageLocationML46Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML46Test extends Injectable
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
        $this->mappingLocationIndex->getLocationModal()->openFilterBlock();
        $this->mappingLocationIndex->getLocationModal()->resetFilter();
        sleep(3);
        $this->mappingLocationIndex->getLocationModal()->getApplyButtonFilter()->click();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();

        sleep(1);
    }
}