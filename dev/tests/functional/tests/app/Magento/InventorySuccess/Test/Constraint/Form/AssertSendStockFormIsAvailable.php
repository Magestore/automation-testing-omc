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
		$sectionName = 'general_information';
		$fieldName = 'transferstock_code';
		\PHPUnit_Framework_Assert::assertTrue(
			$sendStockEdit->getSendStockForm()->getSection('general_information')->isVisible(),
			'Section '.$sectionName.' is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$sendStockEdit->getSendStockForm()->getField($fieldName)->isVisible(),
			'Field "'.$fieldName.'" is not shown'
		);
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