<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 09:46
 */

namespace Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Mapping locations - Warehouses
 * Testcase: ML34 - Check GUI
 *
 * Precondition
 * - Empty
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Mapping Locations - Warehouses] button
 *
 * Acceptance
 * - Redirect to [Mapping Locations - Warehouses] page including:
 * - buttons: Cancel, Save, Choose Locations
 * - grid with 3 columns: Location, Warehouse (drop down style), Actions (Remove action)
 *
 *
 * Class WebposManageLocationML34Test
 * @package Magento\Webpos\Test\TestCase\Location\MappingLocationsWarehouses
 */
class WebposManageLocationML34Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;
    /**
     * Webpos Location Mapping page
     *
     * @var $mappingLocationIndex
     */
    private $mappingLocationIndex;

    /**
     * @param LocationIndex $locationIndex
     */
    public function __inject(
        LocationIndex $locationIndex,
        MappingLocationIndex $mappingLocationIndex
    )
    {
        $this->locationIndex = $locationIndex;
        $this->mappingLocationIndex = $mappingLocationIndex;
    }

    public function test()
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitPageToLoad();
    }
}

