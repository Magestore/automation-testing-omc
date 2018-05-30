<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertSearchExistLocationSuccess;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Add Location
 * Tescase: ML18 - Create Location successfully with all required fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Add Location] button
 * 2. Fill out correctly all required fields
 * 3. Click on [Save] button
 *
 *
 * Acceptance Criteria
 * 3.
 * - Create Location successfully
 * - Redirect to Manage Locations page and the information of the created Location will be shown exactly on grid
 * - Show message: "Location was successfully saved"
 *
 *
 * Class WebposManageLocationML18Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML18Test extends Injectable
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
     * Inject location pages.
     *
     * @param LocationIndex
     * @return void
     */
    private $assertSearchLocation;


    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews,
        AssertSearchExistLocationSuccess $assertSearchExistLocationSuccess
    )
    {
        $this->locationIndex = $locationIndex;
        $this->locationNews = $locationNews;
        $this->assertSearchLocation = $assertSearchExistLocationSuccess;
    }

    public function test(Location $location)
    {
        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getPageActionsBlock()->addNew();
        sleep(1);
        $this->locationNews->getLocationsForm()->fill($location);
        $this->locationNews->getFormPageActions()->save();
        sleep(2);
        $this->assertSearchLocation->processAssert($this->locationIndex, $location->getData());

    }
}

