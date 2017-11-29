<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 14:06
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\QuotationNew;

class AssertAddNewQuotationFormIsAvailable extends AbstractConstraint
{
	public function processAssert(QuotationNew $quotationNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'purchased_at'
			],
		];
		foreach ($sectionList as $section) {
			$quotationNew->getQuotationForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$quotationNew->getQuotationForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$quotationNew->getQuotationForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Quotation Form is available";
	}
}