<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 13:57
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\PurchaseOrderNew;

class AssertAddNewPurchaseOrderFormIsAvailable extends AbstractConstraint
{
	public function processAssert(PurchaseOrderNew $purchaseOrderNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'purchased_at'
			],
		];
		$purchaseOrderNew->getPurchaseOrderForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$purchaseOrderNew->getPurchaseOrderForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$purchaseOrderNew->getPurchaseOrderForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$purchaseOrderNew->getPurchaseOrderForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Purchase Order Form is available";
	}
}