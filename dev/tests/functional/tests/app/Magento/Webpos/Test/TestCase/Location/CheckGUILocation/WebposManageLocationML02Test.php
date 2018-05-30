<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 2:17 PM
 */

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;

/**
 * Check Gui
 * Testcase ML02 - Add new location page
 *
 * Precondition
 * Go to backend
 *
 * Steps
 * 1.Go to Sales-> Manage Location
 * 2. Click on [Add Location] button
 *
 * Acceptance Criteria
 * 2. Display [New Location] page including:
 * - Title: New Location
 * - General information contains fields: Location name (*), Store view (*), Address, Description, Warehouse
 * - Buttons: Back, Reset, Save and continue Edit, Save
 *
 * Class WebposManageLocationML02Test
 * @package Magento\Webpos\Test\TestCase\Location\AddLocation
 */
class WebposManageLocationML02Test extends Injectable
{
    /**
     * Location Index Page
     * @var $_locationIndex
     */
    protected $_locationIndex;

    /**
     * Location Add New Page
     * @var $_locationNews
     */
    protected $_locationNews;


    public function __inject(
        LocationIndex $locationIndex,
        LocationNews $locationNews
    )
    {
        $this->_locationIndex = $locationIndex;
        $this->_locationNews = $locationNews;
    }

    public function test()
    {
        $this->_locationIndex->open();
        $this->_locationIndex->getPageActionsBlock()->addNew();
        sleep(2);
    }
}