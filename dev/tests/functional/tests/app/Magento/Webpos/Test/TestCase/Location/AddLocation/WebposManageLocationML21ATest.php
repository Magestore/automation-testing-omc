<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 11/05/2018
 * Time: 16:23
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertLocationGridWithResult;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;
use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;

/**
 * Add Location
 * Testcase ML21-1 - Check Location Modal show on mapping Location
 *
 * Precondition
 * - Empty
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Add Location] button
 * - Fill out correctly all fields [Warehouse]: Don't link to any warehouse
 * - Click on [Save] button
 * - Click on [Mapping locations - Warehouses] button > Click on [Choose Locations] button
 *
 * Acceptance
 * - The created location will be shown on the grid
 *
 * Class WebposManageLocationML21ATest
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML21ATest extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * @var LocationNews
     */
    private $locationNews;

    /**
     * @var MappingLocation
     */
    private $mappingLocationIndex;

    /**
     * @var $_asssertGridWithResult
     */
    private $asssertGridWithResult;

    /**
     * Inject location pages.
     *
     * @param LocationIndex $locationIndex
     * @param LocationNews $locationNews
     */
    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews,
        MappingLocationIndex $mappingLocationIndex,
        AssertLocationGridWithResult $assertLocationGridWithResult

    )
    {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
        $this->mappingLocationIndex = $mappingLocationIndex;
        $this->asssertGridWithResult = $assertLocationGridWithResult;
    }

    public function test(Location $location)
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getPageActionsBlock()->addNew();
        $this->locationNews->getLocationsForm()->fill($location);
        $this->locationNews->getFormPageActionsLocation()->save();
        $this->locationIndex->getLocationsGrid()->waitLoader();

        /*Mapping Location*/
        $this->locationIndex->getMappingAction()->mappingButton();
        $this->mappingLocationIndex->getMappingLocationGrid()->waitLoader();
        $this->mappingLocationIndex->getMappingLocationGrid()->chooseLocations();
        $this->mappingLocationIndex->getLocationModal()->waitLoader();
    }
}

