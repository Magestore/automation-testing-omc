<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 10:07 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Check Filter function
 * Testcase ML07 - Sort by Address column
 *
 * Precondition
 * 1. Click on [Filters] button
 * 2. Click on [Cancel] button
 *
 * Steps
 * 1. Open Filters form including:
 * - Fileds: ID, Location name, Description, Address
 * - Buttons: Cancel, Apply Filters
 * 2. Close Filters form
 *
 * Acceptance Criteria
 * 1. The records on grid will be sorted in ascending order (A to Z) by Location name
 * 2. The records on grid will be sorted in descending order (Z to A) by Location name
 *
 * Class WebposManageLocationML07Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */
class WebposManageLocationML07Test extends Injectable
{
    /**
     * Location Grid Page
     * @var $_locationIndex
     */
    protected $_locationIndex;

    /**
     * Inject Location Index Page
     *
     * @param LocationIndex $locationIndex
     */
    public function __inject(
        LocationIndex $locationIndex
    )
    {
        $this->_locationIndex = $locationIndex;
    }

    public function test()
    {
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->getFilterButton()->click();
        $this->_locationIndex->getLocationsGrid()->waitForFilterCancelButton();
        $this->_locationIndex->getLocationsGrid()->getFilterCancelButton()->click();
    }
}