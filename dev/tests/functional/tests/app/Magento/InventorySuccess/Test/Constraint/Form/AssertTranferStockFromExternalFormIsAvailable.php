<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 09:33
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\TranferStockFromExternalNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertTranferStockFromExternalFormIsAvailable extends AbstractConstraint
{
	public function processAssert(TranferStockFromExternalNew $tranferStockFromExternalNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'transferstock_code'
			],
		];
		foreach ($sectionList as $section) {
			$tranferStockFromExternalNew->getTranferStockForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$tranferStockFromExternalNew->getTranferStockForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$tranferStockFromExternalNew->getTranferStockForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Tranfer Stock From External Form is available";
	}
}