<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 09:05
 */

namespace Magento\InventorySuccess\Test\Constraint\Menu;


use Magento\InventorySuccess\Test\Page\Adminhtml\ManageStockIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertWarehouseProductListIsAvailable extends AbstractConstraint
{
	public function processAssert(ManageStockIndex $manageStockIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$manageStockIndex->getGeneralBlock()->getSelectWarehouseOption()->isVisible(),
			'Manage Stock - Warehouse Select Field is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$manageStockIndex->getProductGrid()->getListProductsTable()->isVisible(),
			'Manage Stock - Warehouse product list table is not visible'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stock - Warehouse product list is available";
	}
}