<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/5/2018
 * Time: 2:18 PM
 */

namespace Magento\Webpos\Test\TestCase\Location\ChooseLocations;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Check [Choose locations] page
 * TestCase ML41 - Check [Cancel] button
 *
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Mapping Locations - Warehouses] button
 * 2. Click on [Choose Locations] button
 *
 * Acceptance Criteria
 * 2. Show [Choose locations] page including:
 * - 2 buttons: Cancel, Add selected locations
 * - Filter function
 * - A grid shows the locations that dont link to any warehouse
 *
 * Class WebposManageLocationML41Test
 * @package Magento\Webpos\Test\TestCase\Location\ChooseLocations
 */
class WebposManageLocationML41Test extends Injectable
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
     *
     */
    public function test()
    {
        $this->mappingLocationIndex->open();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
        sleep(2);
        $this->mappingLocationIndex->getLocationModal()->getCancelButton()->click();
        sleep(1);
    }
}