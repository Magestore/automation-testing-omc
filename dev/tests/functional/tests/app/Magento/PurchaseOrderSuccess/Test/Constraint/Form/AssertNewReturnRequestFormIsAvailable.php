<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 14:15
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\ReturnOrderNew;

class AssertNewReturnRequestFormIsAvailable extends AbstractConstraint
{
	public function processAssert(ReturnOrderNew $returnOrderNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'returned_at'
			],
		];
		$returnOrderNew->getReturnOrderForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$returnOrderNew->getReturnOrderForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$returnOrderNew->getReturnOrderForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$returnOrderNew->getReturnOrderForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Return Request Form is available";
	}
}