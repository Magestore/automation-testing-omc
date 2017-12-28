<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/27/2017
 * Time: 1:24 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Quotation;

use Magento\Mtf\Client\Locator;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;

/**
 * Class QuotationGrid
 * @package Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Quotation
 */
class QuotationGrid extends DataGrid
{
    /**
     * @var string
     */
    protected $gridTable = '.data-grid';

    /**
     * @var string
     */
    protected $loadingMask = '.admin__data-grid-loading-mask';

    /**
     * @var string
     */
    protected $gridSearchControl = '.data-grid-search-control-wrap';

    /**
     * @var string
     */
    protected $dataGridAction = '.admin__data-grid-actions-wrap';

    /**
     * @var string
     */
    protected $dataGridPager = '.admin__data-grid-pager-wrap';

    /**
     * @var array
     */
    protected $filters = [
        'purchased_at[from]' => [
            'selector' => '[name="purchased_at[from]"]'
        ],
        'purchased_at[to]' => [
            'selector' => '[name="purchased_at[to]"]'
        ],
        'total_qty_orderred[from]' => [
            'selector' => '[name="total_qty_orderred[from]"]'
        ],
        'total_qty_orderred[to]' => [
            'selector' => '[name="total_qty_orderred[to]"]'
        ],
        'grand_total_incl_tax[from]' => [
            'selector' => '[name="grand_total_incl_tax[from]"]'
        ],
        'grand_total_incl_tax[to]' => [
            'selector' => '[name="grand_total_incl_tax[to]"]'
        ],
        'purchase_code' => [
            'selector' => '[name="purchase_code"]'
        ],
        'supplier_id' => [
            'selector' => '[name="supplier_id"]',
            'input'    => 'select'
        ],
        'status' => [
            'selector' => '[name="status"]',
            'input'    => 'select',
        ]
    ];

    /**
     *
     */
    public function resetFilter()
    {
        $this->waitLoader();
        parent::resetFilter();
    }

    /**
     * @param $column
     * @return mixed
     */
    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->columnHeader, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     *
     */
    public function waitingForGridVisible()
    {
//        $this->waitLoader();
        $this->waitForElementNotVisible($this->loadingMask, Locator::SELECTOR_CSS);
        $this->waitForElementVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    /**
     *
     */
    public function waitingForGridNotVisible()
    {
        $this->waitForElementNotVisible($this->gridTable, Locator::SELECTOR_CSS);
    }

    /**
     * @return mixed
     */
    public function dataGridSearchIsVisible()
    {
        return $this->_rootElement->find($this->gridSearchControl, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function actionButtonIsVisible()
    {
        return $this->_rootElement->find($this->actionButton, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function filtersButtonIsVisible()
    {
        return $this->_rootElement->find($this->filterButton, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function dataGridActionIsVisible()
    {
        return $this->_rootElement->find($this->dataGridAction, Locator::SELECTOR_CSS)->isVisible();
    }

    /**
     * @return mixed
     */
    public function dataGridPagerIsVisible()
    {
        return $this->_rootElement->find($this->dataGridPager, Locator::SELECTOR_CSS)->isVisible();
    }
}