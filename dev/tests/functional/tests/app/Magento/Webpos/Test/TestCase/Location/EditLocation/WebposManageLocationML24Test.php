<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 09/05/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Location\EditLocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Fixture\Location;


/**
 * Edit Location
 * ML24-Check GUI Edit Location page
 *
 * Precondition
 * Exist at least 1 Location on the grid of Manage Locations page
 *
 *Steps
 * 1.Go to backend > Sales > Manage Locations
 * 2.Click on [Edit] button to edit the Location
 *
 * Class WebposManageLocationML24Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocation
 */
class WebposManageLocationML24Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * Grid Location Page
     *
     * @param LocationIndex $locationIndex
     */
    public function __inject(
        LocationIndex $locationIndex
    ) {
        $this->locationIndex = $locationIndex;
    }

    public function test(Location $location)
    {
        // Steps
        $location->persist();
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        $filter = [
            'display_name' => $location->getDisplayName()
        ];
        $this->locationIndex->getLocationsGrid()->searchAndOpen($filter);
        sleep(1);
        return [
            'location' => $location
        ];
    }
}

