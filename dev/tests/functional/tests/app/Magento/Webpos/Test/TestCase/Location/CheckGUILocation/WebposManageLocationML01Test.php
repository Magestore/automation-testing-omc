<?php
namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 8:18 AM
 */

/**
 * TestCase ML01
 * Manage location-CheckGUI-Manage location page
 *
 * Precondition
 * Goto Backend
 *
 * Steps
 * 1.Go to Sales > Manage Locations
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

    public function __inject(LocationIndex $locationIndex){
        $this->_locationIndex = $locationIndex;
    }

    public function test(){
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
    }

}