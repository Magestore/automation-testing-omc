<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 10/05/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Location\EditLocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Edit Location
 * ML26 - Check [Save] button with editing
 *
 * Precondition
 * - Exist at least 1 Location on the grid of Manage Locations page
 *
 * Steps
 * 1. Go to backend > Sales > Manage Locations
 * 2. Click on [Edit] button to edit the Location
 * 3. Edit correctly some fields
 * 4. Click on [Save] button
 *
 * Acceptance
 * - Back to the Manage Location page
 * - Show message: "Location was successfully saved"
 * - The information of that Location is updated correctly follow the edited fields
 *
 * Class WebposManageLocationML26Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocation
 */
class WebposManageLocationML26Test extends Injectable
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
        $this->locationNews->getLocationsForm()->getField('page_display_name')->setValue('Test Edit Name '.$location->getDisplayName());
        $this->locationNews->getLocationsForm()->getField('page_address')->setValue('Test Edit Address '.$location->getAddress());
        $this->locationNews->getLocationsForm()->getField('page_description')->setValue('Test Edit Description '.$location->getDescription());
        $this->locationNews->getFormPageActions()->save();
        return[
            'page' => 'index'
        ];
    }
}

