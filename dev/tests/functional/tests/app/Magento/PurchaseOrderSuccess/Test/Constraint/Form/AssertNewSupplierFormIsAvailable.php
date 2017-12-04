<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 14:39
 */

namespace Magento\PurchaseOrderSuccess\Test\Constraint\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SupplierNew;

class AssertNewSupplierFormIsAvailable extends AbstractConstraint
{
	public function processAssert(SupplierNew $supplierNew)
	{
		$sectionList = [
			[
				'sectionName' => 'information',
				'fieldName' => 'supplier_code'
			],
			[
				'sectionName' => 'address',
				'fieldName' => 'telephone'
			],
			[
				'sectionName' => 'password',
				'fieldName' => 'new_password'
			],
		];
		$supplierNew->getSupplierForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$supplierNew->getSupplierForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$supplierNew->getSupplierForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$supplierNew->getSupplierForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Supplier Form is available";
	}
}