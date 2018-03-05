<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/5/2018
 * Time: 3:23 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\MappingLocation;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;

/**
 * Class MappingLocationGrid
 * @package Magento\Webpos\Test\Block\Adminhtml\MappingLocation
 */
class LocationModal extends DataGrid
{
    /**
     * Grid fields map
     *
     * @var array
     */
    protected $filters = [
        'label' => [
            'selector' => '[name="frontend_label"]',
        ]
    ];

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButton()
    {
        return $this->_rootElement->find('//div[2]/header/div/div/div/button[1]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getAddButton()
    {
        return $this->_rootElement->find('//div[2]/header/div/div/div/button[2]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getDataGridHeader()
    {
        return $this->_rootElement->find('.admin__data-grid-header');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getDataGridWrap()
    {
        return $this->_rootElement->find('.admin__data-grid-wrap');
    }

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
     * Wait loader
     *
     * @return void
     */
    public function waitLoader()
    {
        $this->waitForElementNotVisible($this->loader);
        $this->getTemplateBlock()->waitLoader();
    }
}
