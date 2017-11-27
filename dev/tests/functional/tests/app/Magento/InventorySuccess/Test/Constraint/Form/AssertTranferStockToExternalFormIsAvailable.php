<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 09:33
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\TranferStockToExternalNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertTranferStockToExternalFormIsAvailable extends AbstractConstraint
{
	public function processAssert(TranferStockToExternalNew $tranferStockToExternalNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'transferstock_code'
			],
		];
		foreach ($sectionList as $section) {
			$tranferStockToExternalNew->getTranferStockForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$tranferStockToExternalNew->getTranferStockForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$tranferStockToExternalNew->getTranferStockForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Tranfer Stock To External Form is available";
	}
}