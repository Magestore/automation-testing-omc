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
 * Managelocation-ML07
 *
 * Check [Cancel] button
 *
 * Precondition
 *
 *
 * Steps
 * 1.Go to backend->Sales->Manage Location
 * 2. Click filter button
 * 3. Click Cancel button
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

    public function __inject(
        LocationIndex $locationIndex
    ){
        $this->_locationIndex = $locationIndex;
    }

    public function test(){
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->getFilterButton()->click();
        $this->_locationIndex->getLocationsGrid()->waitForFilterCancelButton();
        $this->_locationIndex->getLocationsGrid()->getFilterCancelButton()->click();
    }
}