<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 17:07
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\SendStockEdit;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSendStockFormIsAvailable extends AbstractConstraint
{
	public function processAssert(SendStockEdit $sendStockEdit)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'transferstock_code'
			],
		];
		$sendStockEdit->getSendStockForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$sendStockEdit->getSendStockForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$sendStockEdit->getSendStockForm()->getSection($section['sectionName'])->isVisible(),
				'Section '.$section['sectionName'].' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$sendStockEdit->getSendStockForm()->getField($section['fieldName'])->isVisible(),
				'Field "'.$section['fieldName'].'" is not shown'
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
		return "Add New Send Stock Form is available";
	}
}