<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 10:06 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Check Filter function
 * Testcase ML08 - Check [Apply Filters] button with no results
 *
 * Precondition
 * 1. Click on [Filters] button
 * 2. Input data into some fields that dont match any record
 * 3. Click on [Apply Filters] button
 *
 * Steps
 * 3.
 * - Close Filter form
 * - Show message: "We couldn't find any records." on the Grid
 *
 * Acceptance Criteria
 * 1. The records on grid will be sorted in ascending order (A to Z) by Location name
 * 2. The records on grid will be sorted in descending order (Z to A) by Location name
 *
 * Class WebposManageLocationML08Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */
class WebposManageLocationML08Test extends Injectable
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

    public function test($location)
    {
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->getFilterButton()->click();
        $this->_locationIndex->getLocationsGrid()->resetFilter();
        $this->_locationIndex->getLocationsGrid()->search([
            'description' => $location['description'],
            'address' => $location['address'],
            'display_name' => $location['display_name']
        ]);
        sleep(1);
    }
}