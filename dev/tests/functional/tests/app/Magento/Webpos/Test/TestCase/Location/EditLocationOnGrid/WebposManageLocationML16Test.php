<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Location\EditLocationOnGrid;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Staff\Permission\AssertEditDiscountCustomPrice;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertMessageEditSuccessOnGrid;

/**
 * Edit Location on the grid
 * Testcase ML16 - Check [Save] button
 * Precondition:
 * - Exist at least 1 record on the grid
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on a record on the grid
 * 2. Edit correctly some fields
 * 3. Click on [Save] button
 *
 * Acceptance Criteria
 *  3.
 * -  All fields will be updated and inactive.
 * - Show message: "You have successfully saved your edits"
 *
 * Class WebposManageLocationML16Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocationOnGrid
 */
class WebposManageLocationML16Test extends Injectable
{
    /**
     * Webpos Location Index page.
     *
     * @var LocationIndex
     */
    private $locationIndex;

    /**
     * Inject location pages.
     *
     * @param LocationIndex
     * @return void
     */
    public function __inject(
        LocationIndex $locationIndex
    )
    {
        $this->locationIndex = $locationIndex;
    }

    public function test(Location $location)
    {
        // Preconditions:
        $location->persist();

        // Steps
        $this->locationIndex->open();
        $this->locationIndex->getLocationsGrid()->search(['display_name' => $location->getDisplayName()]);
        $this->locationIndex->getLocationsGrid()->getRowByDisplayName($location->getDisplayName())->click();
        $this->locationIndex->getLocationsGrid()->setAddress('test' . $location->getAddress());
        $this->locationIndex->getLocationsGrid()->setLocationName('test' . $location->getDisplayName());
        $this->locationIndex->getLocationsGrid()->setDescription('test' . $location->getDescription());
        $this->locationIndex->getLocationsGrid()->getActionButtonEditing('Save')->click();
        sleep(2);
        $this->locationIndex->getLocationsGrid()->waitLoader();

        $locationId = $this->locationIndex->getLocationsGrid()->getAllIds()[0];
        return ['dataDisplay' =>
            [
                'location_id' => $locationId,
                'description' => 'test' . $location->getDescription(),
                'address' => 'test' . $location->getAddress(),
                'locationName' => 'test' . $location->getDisplayName()
            ]
        ];
    }
}

