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
     * Locator value for 'Search' button
     *
     * @var string
     */
    protected $cancelButtonFilter = '[data-action="grid-filter-cancel"]';

    /**
     * @var string
     */
    protected $chooseLocations = '.action-basic';

    /**
     * First row selector.
     *
     * @var string
     */
    protected $firstRowSelector = '//tbody/tr/td[4]';

    protected $filterButton = 'button[data-action="grid-filter-expand"]';
    /**
     * Grid fields map
     *
     * @var array
     */
    protected $filters = [
        'location_id[from]' => [
            'selector' => '[name="location_id[from]"]',
        ],
        'location_id[to]' => [
            'selector' => '[name="location_id[to]"]',
        ],
        'display_name' => [
            'selector' => '[name="display_name"]',
        ],
        'address' => [
            'selector' => '[name="address"]',
        ],
        'description' => [
            'selector' => '[name="description"]',
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
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getModalOverlay()
    {
        return $this->_rootElement->find('.modals-overlay');
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
     * Open "Filter" block.
     *
     * @return void
     */
    public function openFilterBlock()
    {
        $this->waitFilterToLoad();
        $toggleFilterButton = $this->_rootElement->find($this->filterButton);
        $searchButton = $this->_rootElement->find($this->searchButton);
        if ($toggleFilterButton->isVisible() && !$searchButton->isVisible()) {
            $toggleFilterButton->click();
            $browser = $this->_rootElement;
            $browser->waitUntil(
                function () use ($searchButton) {
                    return $searchButton->isVisible() ? true : null;
                }
            );
        }
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getRowNoData()
    {
        return $this->_rootElement->find('.data-grid-tr-no-data');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFilterBlock()
    {
        return $this->_rootElement->find('.admin__data-grid-filters-wrap');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButtonFilter()
    {
        return $this->_rootElement->find('[data-action="grid-filter-cancel"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getApplyButtonFilter()
    {
        return $this->_rootElement->find('[data-action="grid-filter-apply"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFieldIdFrom()
    {
        return $this->_rootElement->find('[name="location_id[from]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFieldIdTo()
    {
        return $this->_rootElement->find('[name="location_id[to]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFieldDisplayName()
    {
        return $this->_rootElement->find('[name="display_name');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFieldAddress()
    {
        return $this->_rootElement->find('[name="address');
    }

    public function selectRow($filter)
    {
        $rowItem = $this->getRow($filter);
        if ($rowItem->isVisible()) {
            $rowItem->find($this->selectItem)->click();
        } else {
            throw new \Exception("Searched item was not found by filter\n" . print_r($filter, true));
        }
        $this->waitLoader();
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFieldDescription()
    {
        return $this->_rootElement->find('[name="description');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFilterFirstId()
    {
        return $this->_rootElement->find('//table[@class="data-grid data-grid-draggable"]/tbody/tr[1]/td[2]', Locator::SELECTOR_XPATH);
    }

    public function getFilterFirstDisplayName()
    {
        return $this->_rootElement->find('//table[@class="data-grid data-grid-draggable"]/tbody/tr[1]/td[3]', Locator::SELECTOR_XPATH);
    }

    public function getFilterFirstAddress()
    {
        return $this->_rootElement->find('//table[@class="data-grid data-grid-draggable"]/tbody/tr[1]/td[4]', Locator::SELECTOR_XPATH);
    }

    public function getFilterFirstDescription()
    {
        return $this->_rootElement->find('//table[@class="data-grid data-grid-draggable"]/tbody/tr[1]/td[5]', Locator::SELECTOR_XPATH);
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
        $this->waitForElementVisible('table.data-grid');
    }

    public function waitClose()
    {
        $this->waitForElementNotVisible('.modal-slide');
    }

    public function getClearFilterButton()
    {
        return $this->_rootElement->find('.action-clear');
    }

    public function isClearButtonVisible()
    {
        $this->waitLoader();
        return $this->_rootElement->find('.action-clear')->isVisible();
    }

}
