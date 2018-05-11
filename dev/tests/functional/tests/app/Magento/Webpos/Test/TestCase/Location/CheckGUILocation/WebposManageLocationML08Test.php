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
 * Managelocation-ML08
 *
 * Check [Apply Filters] button with no results
 *
 * Precondition
 * Exist at least 2 records on the grid
 *
 * Steps
 * 1.Go to backend->Sales->Manage Location
 * 2. Click filter button
 * 3. Input data into some fields that dont match any record
 * 4. Click Filter button
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
    ){
        $this->_locationIndex = $locationIndex;
    }

    public function test($location){
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