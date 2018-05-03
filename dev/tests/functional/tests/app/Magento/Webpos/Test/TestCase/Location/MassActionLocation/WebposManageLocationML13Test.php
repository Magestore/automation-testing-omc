<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 10:06 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\MassActionLocation;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid\AssertGridFilterNoResult;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Managelocation-ML13
 *
 * Delete Many Location
 *
 * Precondition
 * Exist at least 2 records on the grid
 *
 * Steps
 * 1.Go to backend->Sales->Manage Location
 * 2.Tick on some checkboxs to select more than 1 Location on the grid
 * 3.Click on Mass action > Delete
 * 4.Click on [OK] button
 *
 * Class WebposManageLocationML12Test
 * @package Magento\Webpos\Test\TestCase\Location\MassActionLocation
 */
class WebposManageLocationML13Test extends Injectable
{
    /**
     * Location Grid Page
     * @var $_locationIndex
     */
    protected $_locationIndex;
    protected $_assertGridWithNoResult;

    public function __inject(
        LocationIndex $locationIndex,
        AssertGridFilterNoResult $assertGridWithNoResult
    ){
        $this->_locationIndex = $locationIndex;
        $this->_assertGridWithNoResult = $assertGridWithNoResult;
    }

    public function test(Location $location1, Location $location2){
        $location1->persist();
        $location2->persist();
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->resetFilter();
        $this->_locationIndex->getLocationsGrid()->selectItems([
            [
                'display_name' => $location1->getDisplayName()
            ],
            [
                'display_name' => $location2->getDisplayName()
            ]
        ]);
        $this->_locationIndex->getLocationsGrid()->selectAction('Delete');
        $this->_locationIndex->getModal()->waitForLoader();
        $this->_locationIndex->getModal()->getOkButton()->click();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        sleep(2);
        /*Check Location 1*/
        $this->_locationIndex->getLocationsGrid()->search(['display_name' => $location1->getDisplayName()]);
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_assertGridWithNoResult->processAssert($this->_locationIndex);

        /*Check Location 1*/
        $this->_locationIndex->getLocationsGrid()->search(['display_name' => $location2->getDisplayName()]);
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_assertGridWithNoResult->processAssert($this->_locationIndex);
        sleep(1);
    }
}