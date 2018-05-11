<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 10:06 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\MassActionLocation;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Managelocation-ML12
 *
 * Delete Location
 *
 * Precondition
 * Exist at least 1 records on the grid
 *
 * Steps
 * 1.Go to backend->Sales->Manage Location
 * 2.Tick on checkbox to select 1 Location on the grid
 * 3.Click on Mass action > Delete
 * 4.Click on [OK] button
 *
 * Class WebposManageLocationML12Test
 * @package Magento\Webpos\Test\TestCase\Location\MassActionLocation
 */
class WebposManageLocationML12Test extends Injectable
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

    public function test(Location $location){
        $location->persist();
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->getFilterButton()->click();
        $this->_locationIndex->getLocationsGrid()->resetFilter();
        $this->_locationIndex->getLocationsGrid()->searchAndSelect([
            'display_name' => $location->getDisplayName()
        ]);
        $this->_locationIndex->getLocationsGrid()->selectAction('Delete');
        $this->_locationIndex->getModal()->waitForLoader();
        $this->_locationIndex->getModal()->getOkButton()->click();
        $this->_locationIndex->getLocationsGrid()->waitLoader();

        /*Check just deleted location*/
        $this->_locationIndex->getLocationsGrid()->resetFilter();
        $this->_locationIndex->getLocationsGrid()->search([
            'display_name' => $location->getDisplayName()
        ]);
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        sleep(1);
    }
}