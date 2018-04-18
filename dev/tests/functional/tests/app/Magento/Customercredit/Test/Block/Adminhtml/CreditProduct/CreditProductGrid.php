<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 11:07 PM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\CreditProduct;

use Magento\Customercredit\Test\Block\Adminhtml\CreditDataGrid;
use Magento\Mtf\Client\Element\SimpleElement;
use Magento\Mtf\Client\Locator;

/**
 * Class CreditProductGrid
 * @package Magento\Customercredit\Test\Block\Adminhtml\CreditProduct
 */
class CreditProductGrid extends CreditDataGrid
{
    /**
     * An element locator which allows to select first entity in grid.
     *
     * @var string
     */
    protected $editLink = '#promo_catalog_grid_table tbody tr:first-child td';

    /**
     * First row selector.
     *
     * @var string
     */
    protected $firstRowSelector = '//tr[@data-role="row"]/td[@data-column="rule_id"]';

    /**
     * Column header locator.
     *
     * @var string
     */
    protected $columnHeader = './/*[@id="customercreditproductGrid"]//th/span[.="%s"]';

    /**
     * Filters array mapping.
     *
     * @var array
     */
    protected $filters = [
        'id' => ['selector' => '#customercreditproductGrid_product_filter_entity_id_from'
        ],
        'id_from' => [
            'selector' => '#customercreditproductGrid_product_filter_entity_id_from'
        ],
        'id_to' => [
            'selector' => '#customercreditproductGrid_product_filter_entity_id_to'
        ],
        'name' => [
            'selector' => '#customercreditproductGrid_product_filter_name'
        ],
        'sku' => [
            'selector' => '#customercreditproductGrid_product_filter_sku'
        ],
        'qty_from' => [
            'selector' => '#customercreditproductGrid_product_filter_qty_from'
        ],
        'qty_to' => [
            'selector' => '#customercreditproductGrid_product_filter_qty_to'
        ],
        'visibility' => [
            'selector' => '#customercreditproductGrid_product_filter_visibility',
            'input' => 'select'
        ],
        'status' => [
            'selector' => '#customercreditproductGrid_product_filter_status',
            'input' => 'select'
        ],
        'website_ids' => [
            'selector' => '#customercreditproductGrid_product_filter_websites',
            'input' => 'select'
        ]
    ];

    protected $massactionStatus = '[data-ui-id="widget-grid-massaction-item-additional-defaultadditional-0-element-select-status"]';

    /**
     * Return row with given catalog price rule name.
     *
     * @param string $ruleName
     * @return SimpleElement
     */
    public function getGridRow($ruleName)
    {
        return $this->getRow(['name' => $ruleName]);
    }

    /**
     * Return id of catalog price rule with given name.
     *
     * @param string $ruleName
     * @return string
     */
    public function getCatalogPriceId($ruleName)
    {
        return $this->getGridRow($ruleName)->find('//td[@data-column="rule_id"]', Locator::SELECTOR_XPATH)->getText();
    }

    /**
     * Check if specific row exists in grid.
     *
     * @param array $filter
     * @param bool $isSearchable
     * @param bool $isStrict
     * @return bool
     */
    public function isRowVisible(array $filter, $isSearchable = true, $isStrict = true)
    {
//        $this->search(['name' => $filter['name']]);
        return parent::isRowVisible($filter, $isSearchable, $isStrict);
    }

    public function getAllIds()
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        $rowsCheckboxes = $this->_rootElement->getElements($this->selectItem);
        $ids = [];
        foreach ($rowsCheckboxes as $checkbox) {
            $ids[] = $checkbox->getValue();
        }
        return $ids;
    }

    /**
     * Sort grid by column.
     *
     * @param string $columnLabel
     */
    public function sortByColumn($columnLabel)
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        $this->_rootElement->find(sprintf($this->columnHeader, $columnLabel), Locator::SELECTOR_XPATH)->click();
        $this->waitLoader();
    }


    /**
     * @return array|string
     */
    public function getFirstItemId()
    {
        $this->waitLoader();
        $this->getTemplateBlock()->waitForElementNotVisible($this->loader);
        return $this->_rootElement->find($this->selectItem)->getValue();
    }

    public function massaction(array $items, $action, $acceptAlert = false, $massActionSelection = '', $status = '')
    {
        if ($this->_rootElement->find($this->noRecords)->isVisible()) {
            return;
        }
        if (!is_array($action)) {
            $action = [$action => '-'];
        }
        foreach ($items as $item) {
            $this->searchAndSelect($item);
        }
        if ($massActionSelection) {
            $this->_rootElement->find($this->massactionAction, Locator::SELECTOR_CSS, 'select')
                ->setValue($massActionSelection);
        }
        $actionType = key($action);
        $this->_rootElement->find($this->massactionSelect, Locator::SELECTOR_CSS, 'select')->setValue($actionType);
        if (isset($action[$actionType]) && $action[$actionType] != '-') {
            $this->_rootElement->find($this->option, Locator::SELECTOR_CSS, 'select')->setValue($action[$actionType]);
        }
        if ($status) {
            $this->_rootElement->find($this->massactionStatus, Locator::SELECTOR_CSS, 'select')
                ->setValue($status);
        }
        $this->massActionSubmit($acceptAlert);
    }
}