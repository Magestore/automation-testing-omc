<?php
/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-07 08:57:00
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 09:42:58
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Locations;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;

class LocationsGrid extends DataGrid
{
    /**
     * Select action toggle.
     *
     * @var string
     */
    // protected $option = '[name="title"]';
    protected $selectAction = '.action-menu-item';

    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'location_id[from]' => [
            'selector' => '.admin__data-grid-filters input[name="location_id[from]"]',
        ],
        'location_id[to]' => [
            'selector' => '.admin__data-grid-filters input[name="location_id[to]"]',
        ],
        'description' => [
            'selector' => '.admin__data-grid-filters input[name="description"]',
        ],
        'address' => [
            'selector' => '.admin__data-grid-filters input[name="address"]',
        ],
        'display_name' => [
            'selector' => '.admin__data-grid-filters input[name="display_name"]',
        ]
    ];

    /**
     * Click on "Edit" link.
     *
     * @param SimpleElement $rowItem
     * @return void
     */
    protected function clickEditLink(SimpleElement $rowItem)
    {
        $rowItem->find($this->selectAction)->click();
    }

    /**
     * Fix core
     */
    public function resetFilter()
    {
        $this->waitLoader();
        parent::resetFilter();
    }

    public function getRowByDisplayName($displayName, $isStrict = true)
    {
        $rowTemplate = ($isStrict) ? $this->rowTemplateStrict : $this->rowTemplate;
        $rows = sprintf($rowTemplate, $displayName);
        $location = sprintf($this->rowPattern, $rows);
        return $this->_rootElement->find($location, Locator::SELECTOR_XPATH);
    }

    public function waitLoader()
    {
        $this->waitForElementNotVisible($this->loader);
        $this->getTemplateBlock()->waitLoader();
    }

    public function getActionButtonEditing($nameButton)
    {
        return $this->_rootElement->find('//tbody/tr/td/button[*[text()[normalize-space()="' . $nameButton . '"]]]', Locator::SELECTOR_XPATH);
    }

    public function setDescription($description)
    {
        $this->_rootElement->find('//tbody/tr/td/*/input[@name="description"]', Locator::SELECTOR_XPATH)->setValue($description);
    }

    public function setAddress($address)
    {
        $this->_rootElement->find('//tbody/tr/td/*/input[@name="address"]', Locator::SELECTOR_XPATH)->setValue($address);
    }

    public function setLocationName($locationName)
    {
        $this->_rootElement->find('//tbody/tr/td/*/input[@name="display_name"]', Locator::SELECTOR_XPATH)->setValue($locationName);
    }

    public function getRowByDescription($description, $isStrict = true)
    {
        $rowTemplate = ($isStrict) ? $this->rowTemplateStrict : $this->rowTemplate;
        $rows = sprintf($rowTemplate, $description);
        $location = sprintf($this->rowPattern, $rows);
        return $this->_rootElement->find($location, Locator::SELECTOR_XPATH);
    }

    public function getInputFieldEdtingByName($name)
    {
        return $this->_rootElement->find('//tbody/tr/td/*/input[@name="' . $name . '"]', Locator::SELECTOR_XPATH);
    }

    public function getInputFieldGridByName($name)
    {
        return $this->_rootElement->find('//thead//th/span[text()="' . $name . '"]', Locator::SELECTOR_XPATH);
    }

    public function getFilterButton(){
        return $this->_rootElement->find('//div[@class="data-grid-filters-actions-wrap"]//button[text()="Filters"]', Locator::SELECTOR_XPATH);
    }

    public function getMassActionOptionByName($name)
    {
            return $this->_rootElement->find('//div[@class="action-menu-items"]//ul//li//span[text()="' . $name . '"]   ', Locator::SELECTOR_XPATH);
    }

    public function getSelectFieldEdtingByName($name)
    {
        return $this->_rootElement->find('//tbody/tr/td/*/select[@name="' . $name . '"]', Locator::SELECTOR_XPATH);
    }

    public function getFieldDisableEditingDisplay($text)
    {
        return $this->_rootElement->find('//tbody/tr/td[*[text()[normalize-space()="' . $text . '"]]]', Locator::SELECTOR_XPATH);
    }

    public function getMessageEditSuccess()
    {
        return $this->_rootElement->find('.data-grid-info-panel .message');
    }

    public function waitForFilterCancelButton()
    {
        $this->waitForElementVisible('//button[@data-action="grid-filter-cancel"]', locator::SELECTOR_XPATH);
    }

    public function waitForFilterForm()
    {
        $this->waitForElementVisible('//admin__data-grid-filters-wrap _show', locator::SELECTOR_XPATH);
    }


    public function getFilterCancelButton()
    {
        return $this->_rootElement->find('.//button[@data-action="grid-filter-cancel"]', locator::SELECTOR_XPATH);
    }

    public function getGridFilterForm(){
        return $this->_rootElement->find('.//div[@class="admin__data-grid-filters-wrap _show"]', locator::SELECTOR_XPATH);
    }

    public function getDataGridFirstRow(){
        return $this->_rootElement->find('.//table//tbody/tr[]', locator::SELECTOR_XPATH);
    }
}
