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
 * Testcase ML09 - Check [Apply Filters] button without condition
 *
 * Precondition
 * 1. Click on [Filters] button
 * 2. Click on [Apply Filters] button
 *
 * Steps
 * 1. Click on [Filters] button
 * 2. Click on [Apply Filters] button
 *
 * Acceptance Criteria
 * 2.
 * - Close Filter form
 * - The grid shows all records
 *
 * Class WebposManageLocationML09Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */
class WebposManageLocationML09Test extends Injectable
{
    /**
     * Location Grid Page
     * @var $_locationIndex
     */
    protected $_locationIndex;

    /**
     * Inject
     *
     * @param LocationIndex $locationIndex
     */
    public function __inject(
        LocationIndex $locationIndex
    )
    {
        $this->_locationIndex = $locationIndex;
    }

    /**
     * Test steps
     */
    public function test()
    {
        $this->_locationIndex->open();
        $this->_locationIndex->getLocationsGrid()->waitLoader();
        $this->_locationIndex->getLocationsGrid()->getFilterButton()->click();
        $this->_locationIndex->getLocationsGrid()->resetFilter();
        $this->_locationIndex->getLocationsGrid()->search([]);
        sleep(1);
    }
}