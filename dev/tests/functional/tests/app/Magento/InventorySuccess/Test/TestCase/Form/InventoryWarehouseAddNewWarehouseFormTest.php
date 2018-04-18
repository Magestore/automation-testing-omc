<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 14:08
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\WarehouseIndex;
use Magento\InventorySuccess\Test\Page\Adminhtml\WarehouseNew;
use Magento\Mtf\TestCase\Injectable;

class InventoryWarehouseAddNewWarehouseFormTest extends Injectable
{
	/**
	 * @var WarehouseIndex
	 */
	protected $warehouseIndex;
	/**
	 * @var WarehouseNew
	 */
	protected $warehouseNew;

	public function __inject(
		WarehouseIndex $warehouseIndex,
		WarehouseNew $warehouseNew
	)
	{
		$this->warehouseIndex = $warehouseIndex;
		$this->warehouseNew = $warehouseNew;
	}

	public function test($pageTitle)
	{
		$this->warehouseIndex->open();
		$this->warehouseIndex->getPageActionsBlock()->addNew();
	}
}