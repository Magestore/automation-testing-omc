<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2019
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Location\AddLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertSearchExistLocationSuccess;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 *  Add Location
 * Tescase: ML19 - Check [Save and continue] button without filling out all fields
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on [Add Location] button
 * 2. Click on [Save and continue edit] button
 *
 *
 * Acceptance Criteria
 * 2.
 * - Create Location unsuccessfully
 * - Show message: "This is a required field." under all required fields
 *
 *
 * Class WebposManageLocationML19Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML19Test extends Injectable
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

