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

/**
 *  Check [Choose locations] page
 * TestCase ML42 - Check [Save] button without selecting location
 *
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 * 3. Click on [Save] button
 *
 * Acceptance Criteria
 * 3. Back to [Mapping locations -warehouses] page
 *
 * Class WebposManageLocationML42Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML42Test extends Injectable
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
     * Test Steps
     */
    public function test()
    {
        $this->mappingLocationIndex->open();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        sleep(2);
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        $this->mappingLocationIndex->getLocationModal()->getAddButton()->click();
        sleep(1);
    }
}