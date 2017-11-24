<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 08:54
 */

namespace Magento\InventorySuccess\Test\Block\Adminhtml\ManageStockIndex;

use Magento\Backend\Test\Block\Widget\Grid as AbstractGrid;

class ProductGrid extends AbstractGrid
{
	/**
	 * Grid filters' selectors
	 *
	 * @var array
	 */
	protected $filters = [
		'sku' => [
			'selector' => '[name="sku"]',
		],
		'name' => [
			'selector' => '[name="name"]',
		],
		'price[from]' => [
			'selector' => '[name="price[from]"]',
		],
		'price[to]' => [
			'selector' => '[name="price[to]"]',
		],
		'sum_total_qty[from]' => [
			'selector' => '[name="sum_total_qty[from]"]',
		],
		'sum_total_qty[to]' => [
			'selector' => '[name="sum_total_qty[to]"]',
		],
		'sum_qty_to_ship[from]' => [
			'selector' => '[name="sum_qty_to_ship[from]"]',
		],
		'sum_qty_to_ship[to]' => [
			'selector' => '[name="sum_qty_to_ship[to]"]',
		],
		'available_qty[from]' => [
			'selector' => '[name="available_qty[from]"]',
		],
		'available_qty[to]' => [
			'selector' => '[name="available_qty[to]"]',
		],
		'action_view' => [
			'selector' => '[name="action_view"]',
		],
		'status' => [
			'selector' => '[name="status"]',
		],
	];

	public function getListProductsTable()
	{
		return $this->_rootElement->find('#warehouse_list_products_table');
	}
}