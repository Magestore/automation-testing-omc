<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:15
 */

namespace Magento\Webpos\Test\TestCase\Location\EditLocationOnGrid;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Edit Location on the grid
 * Testcase ML15 - Check GUI of a record when editing
 * Precondition:
 * - Exist at least 1 record on the grid
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on a record on the grid
 * 2. Click on [Cancel] button
 *
 * Acceptance Criteria
 * 2. The record backs to origin status, all fields will be inactive
 *
 * Class WebposManageLocationML15Test
 * @package Magento\Webpos\Test\TestCase\Location\EditLocationOnGrid
 */
class WebposManageLocationML15Test extends Injectable
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
     * @param LocationIndex $locationIndex
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
        sleep(1);
        $this->locationIndex->getLocationsGrid()->getActionButtonEditing('Cancel')->click();
        $this->locationIndex->getLocationsGrid()->waitLoader();
        sleep(1);

        $locationId = $this->locationIndex->getLocationsGrid()->getAllIds()[0];
        return ['dataDisplay' =>
            [
                'location_id' => $locationId,
                'description' => $location->getDescription(),
                'address' => $location->getAddress(),
                'locationName' => $location->getDisplayName()
            ]
        ];
    }
}

