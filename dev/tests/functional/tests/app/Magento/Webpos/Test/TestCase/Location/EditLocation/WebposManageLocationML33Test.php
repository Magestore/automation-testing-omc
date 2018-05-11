<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 09:36
 */

namespace Magento\Webpos\Test\TestCase\Location\EditLocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Delete Location
 * Testcase ML33 - Check [Back] button
 *
 * Precondition
 * - Exist at least 1 Location on the grid of Manage Locations page
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Edit] button to edit the Location
 * - Click on [Back] button
 *
 * Acceptance
 * - Back to the Manage Locations page
 *
 * Class WebposManageLocationML33Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocation
 */
class WebposManageLocationML33Test extends Injectable
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
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews
    )
    {
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
        $this->locationIndex->getLocationsGrid()->openEditByRow([
            'display_name' => $location->getDisplayName()
        ]);
        $this->locationNews->getFormPageActionsLocation()->back();
        \PHPUnit_Framework_Assert::assertTrue(
            $this->locationIndex->getLocationsGrid()->isVisible(),
            'Manage Location Page could not display'
        );
    }
}

