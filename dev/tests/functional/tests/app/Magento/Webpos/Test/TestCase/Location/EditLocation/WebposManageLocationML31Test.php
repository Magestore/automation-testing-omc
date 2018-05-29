<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 09:00
 */
namespace Magento\Webpos\Test\TestCase\Location\EditLocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Delete Location
 * Testcase: ML31 - Check [Delete] button
 *
 * Precondition
 * - Exist at least 1 Location on the grid of Manage Locations page
 *
 * Steps
 * - Go to backend > Sales > Manage Locations
 * - Click on [Edit] button to edit the Location
 * - Click on [Delete] button
 * - Click on [X] button on the confirmation popup
 *
 *
 * Acceptance
 * - Display a confirmation popup with message: "Are you sure you want to do this?" and 2 buttons: Cancel, OK
 * - Close the confirmation popup and still stay on the Edit Location page
 *
 * Class WebposManageLocationML31Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocation
 */
class WebposManageLocationML31Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex $locationIndex
     */
    private $locationIndex;

    /**
     * @var LocationNews $locationNews
     */
    private $locationNews;

    /**
     * Inject location pages.
     *
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

    /**
     * @param Location $location
     */
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
        $this->locationNews->getModalsWrapper()->waitForLoader();
        $this->locationNews->getModalsWrapper()->getXButton()->click();
        $this->locationNews->getModalsWrapper()->waitForHidden();
        \PHPUnit_Framework_Assert::assertFalse(
            $this->locationNews->getModalsWrapper()->getModalPopup()->isVisible(),
            'Confirm Popup is closed'
        );
    }
}

