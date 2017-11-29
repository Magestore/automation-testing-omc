<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 13:34
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\WarehouseNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertAddNewWarehouseFormIsAvailable extends AbstractConstraint
{
	public function processAssert(WarehouseNew $warehouseNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'warehouse_name'
			],
		];
		foreach ($sectionList as $section) {
			$warehouseNew->getWarehouseForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$warehouseNew->getWarehouseForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$warehouseNew->getWarehouseForm()->getField($section['fieldName'])->isVisible(),
				'Field "' . $section['fieldName'] . '" is not shown'
			);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Add New Warehouse Form is available";
	}
}