<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 09:16
 */
namespace Magento\Webpos\Test\TestCase\Location\EditLocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Delete Location
 * Testcase ML32 - Check [Delete] button
 *
 * Precondition
 * - Exist at least 1 Location on the grid of Manage Locations page
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Edit] button to edit the Location
 * - Click on [Delete] button
 * - Click on [OK] button on the confirmation popup
 *
 *
 * Acceptance
 * - Display a confirmation popup with message: "Are you sure you want to do this?" and 2 buttons: Cancel, OK
 * - Back to Manage Locations page and show message: "Location was successfully deleted"
 *
 * Class WebposManageLocationML32Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocation
 */
class WebposManageLocationML32Test extends Injectable
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
        $this->locationIndex->getLocationsGrid()->openEditByRow([
            'display_name' => $location->getDisplayName()
        ]);
        $this->locationNews->getFormPageActionsLocation()->deleteButton()->click();
        $this->locationNews->getModalsWrapper()->getOkButton()->click();
        return [
            'page' => 'index',
            'location' =>$location
        ];
    }
}

