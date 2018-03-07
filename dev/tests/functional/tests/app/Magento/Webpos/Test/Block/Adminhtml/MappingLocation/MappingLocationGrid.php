<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/5/2018
 * Time: 2:49 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\MappingLocation;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;

/**
 * Class MappingLocationGrid
 * @package Magento\Webpos\Test\Block\Adminhtml\MappingLocation
 */
class MappingLocationGrid extends DataGrid
{
    /**
     * 'Choose Locations' button.
     *
     * @var string
     */
    protected $chooseLocations = '.action-basic';

    /**
     * Magento form loader.
     *
     * @var string
     */
    protected $spinner = '[data-component="os_webpos_locations_listing.os_webpos_locations_listing.os_webpos_locations_listing_columns"]';

    /**
     * Press 'Choose Locations' button.
     *
     * @return void
     */
    public function chooseLocations()
    {
        $this->_rootElement->find($this->chooseLocations, Locator::SELECTOR_CSS)->click();
        $this->getTemplateBlock()->waitLoader();
    }

    /**
     * Wait page to load.
     *
     * @return void
     */
    public function waitPageToLoad()
    {
        $this->waitForElementNotVisible($this->spinner);
    }
}
