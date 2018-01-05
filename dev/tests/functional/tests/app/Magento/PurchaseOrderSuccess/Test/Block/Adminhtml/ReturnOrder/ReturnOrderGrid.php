<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/28/2017
 * Time: 1:57 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\ReturnOrder;

use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Element\SimpleElement;

/**
 * Class ReturnOrderGrid
 * @package Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\ReturnOrder
 */
class ReturnOrderGrid extends DataGrid
{
    /**
     * @var string
     */
    protected $selectAction = '.action-menu-item';

    /**
     * @var array
     */
    protected $filters = [
        'total_qty_returned[from]' => [
            'selector' => '.admin__data-grid-filters input[name="total_qty_returned[from]"]',
        ],
        'total_qty_returned[to]' => [
            'selector' => '.admin__data-grid-filters input[name="total_qty_returned[to]"]',
        ],
        'total_qty_transferred[from]' => [
            'selector' => '.admin__data-grid-filters input[name="total_qty_transferred[from]"]',
        ],
        'total_qty_transferred[to]' => [
            'selector' => '.admin__data-grid-filters input[name="total_qty_transferred[to]"]',
        ],
        'returned_at[from]' => [
            'selector' => '.admin__data-grid-filters input[name="returned_at[from]"]',
        ],
        'returned_at[to]' => [
            'selector' => '.admin__data-grid-filters input[name="returned_at[to]"]',
        ],
        'return_code' => [
            'selector' => '.admin__data-grid-filters input[name="return_code"]',
        ],
        'supplier_id' => [
            'selector' => '.admin__data-grid-filters [name="supplier_id"]',
            'input' => 'select'
        ],
        'warehouse_id' => [
            'selector' => '.admin__data-grid-filters input[name="warehouse_id"]',
        ],
        'status' => [
            'selector' => '.admin__data-grid-filters input[name="status"]',
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
}