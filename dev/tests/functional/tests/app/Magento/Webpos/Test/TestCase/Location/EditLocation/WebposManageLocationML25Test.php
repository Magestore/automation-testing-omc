<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 07:59
 */
namespace Magento\Webpos\Test\TestCase\Location\EditLocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Edit Location
 * ML25 - Check [Save] button without editing
 *
 * Precondition
 * Exist at least 1 Location on the grid of Manage Locations page
 *
 *Steps
 * 1. Go to backend > Sales > Manage Locations
 * 2. Click on [Edit] button to edit the Location
 * 3. Click on [Save] button
 *
 * Acceptance
 * Show message: "Location was successfully saved"
 *
 * Class WebposManageLocationML25Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocation
 */
class WebposManageLocationML25Test extends Injectable
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
     * @param LocationIndex $locationIndex
     * @param LocationNews $locationNews
     */
    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews
    ) {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
    }

    public function test(Location $location)
    {
        // Steps
        $location->persist();
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $this->locationIndex->getLocationsGrid()->resetFilter();
        $this->locationIndex->getLocationsGrid()->searchAndOpen([
            'display_name' => $location->getDisplayName()
        ]);
        sleep(1);
        $this->locationNews->getFormPageActions()->save();
    }
}

