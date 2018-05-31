<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 10:06 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Check Filter function
 * Testcase ML09 - Check [Apply Filters] button with full conditions
 *
 * Precondition
 * 1. Click on [Filters] button
 * 2. Input data into all fields that match one or some records
 * 3. Click on [Filters] button
 *
 * Steps
 * 1. Click on [Filters] button
 * 2. Input data into all fields that match one or some records
 * 3. Click on [Filters] button
 *
 * Acceptance Criteria
 * 2.
 * - Close Filter form
 * - The records that matching the condition will be shown on the grid
 *
 *
 * Class WebposManageLocationML10Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */
class WebposManageLocationML10Test extends Injectable
{
    /**
     * Location Grid Page
     * @var $_locationIndex
     */
    protected $_locationIndex;

    public function __inject(
        LocationIndex $locationIndex
    )
    {
        $this->_locationIndex = $locationIndex;
    }

    public function test(Location $location)
    {
        $location->persist();
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->getFilterButton()->click();
        $this->_locationIndex->getLocationsGrid()->resetFilter();
        $this->_locationIndex->getLocationsGrid()->search([
            'description' => $location->getDescription(),
            'display_name' => $location->getDisplayName(),
            'address' => $location->getAddress(),
        ]);
        sleep(1);
    }
}