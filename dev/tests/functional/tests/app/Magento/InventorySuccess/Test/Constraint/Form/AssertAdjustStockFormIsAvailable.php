<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 10:05
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\AdjustStockNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertAdjustStockFormIsAvailable extends AbstractConstraint
{

	public function processAssert(AdjustStockNew $adjustStockNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'warehouse_id'
			],
		];
		foreach ($sectionList as $section) {
			$adjustStockNew->getAdjustStockForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$adjustStockNew->getAdjustStockForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$adjustStockNew->getAdjustStockForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Adjust Stock Form is available";
	}
}