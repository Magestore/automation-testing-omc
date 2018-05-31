<?php

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Check GUI
 * TestCase ML01 - Manage location-CheckGUI-Manage location page
 *
 * Precondition
 * Goto Backend
 *
 * Steps
 * 1.Go to Sales > Manage Locations
 *
 * Acceptance Criteria
 *
 * 1. Display [Manage Location] page including:
 * - Titles: Location
 * - Buttons: Add Location, Mapping Location - Warehouses
 * - The grid with columns: ID, Description, Address, Location name, Action
 * - Mass actions contains: Delete
 * - Filter function
 *
 * Class ManageLocationCheckGUIML01Test
 * @package Magento\Webpos\Test\TestCase\Sync\CheckGUILocation
 */
class WebposManageLocationML01Test extends Injectable
{
    /**
     * Webpos Location Index Page
     * @var $locationIndex
     */
    protected $_locationIndex;

    /**
     * Inject Location Page
     *
     * @param LocationIndex $locationIndex
     */
    public function __inject(LocationIndex $locationIndex)
    {
        $this->_locationIndex = $locationIndex;
    }

    /**
     * Test Steps
     */
    public function test()
    {
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
    }

}