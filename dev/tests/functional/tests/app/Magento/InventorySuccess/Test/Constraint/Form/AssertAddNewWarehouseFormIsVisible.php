<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 14:23
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\WarehouseNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertAddNewWarehouseFormIsVisible extends AbstractConstraint
{
	public function processAssert(WarehouseNew $warehouseNew)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$warehouseNew->getWarehouseForm()->isVisible(),
			'Inventory - Warehouse - Add New Warehouse Form is not visible'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Inventory - Warehouse - Add New Warehouse Form is visible";
	}
}