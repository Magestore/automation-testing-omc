<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 13:15
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\LowStockRuleNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertLowStockRuleFormIsAvailable extends AbstractConstraint
{
	public function processAssert(LowStockRuleNew $lowStockRuleNew)
	{
		$sectionList = [
			[
				'sectionName' => 'rule_information',
				'fieldName' => 'rule_name'
			],
			[
				'sectionName' => 'conditions',
				'fieldName' => 'lowstock_threshold_type'
			],
			[
				'sectionName' => 'actions',
				'fieldName' => 'notifier_emails'
			],
		];
		$lowStockRuleNew->getLowStockRuleForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$lowStockRuleNew->getLowStockRuleForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$lowStockRuleNew->getLowStockRuleForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$lowStockRuleNew->getLowStockRuleForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Low Stock Rule Form is available";
	}
}