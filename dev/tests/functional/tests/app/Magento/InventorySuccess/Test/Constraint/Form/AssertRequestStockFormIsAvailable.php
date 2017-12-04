<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/11/2017
 * Time: 17:07
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\RequestStockNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertRequestStockFormIsAvailable extends AbstractConstraint
{
	public function processAssert(RequestStockNew $requestStockNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'transferstock_code'
			],
		];
		$requestStockNew->getRequestStockForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$requestStockNew->getRequestStockForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$requestStockNew->getRequestStockForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$requestStockNew->getRequestStockForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Request Stock Form is available";
	}
}