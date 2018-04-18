<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/11/2017
 * Time: 10:23
 */

namespace Magento\InventorySuccess\Test\Constraint\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\StocktakingNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertStocktakingFormIsAvailable extends AbstractConstraint
{
	public function processAssert(StocktakingNew $stocktakingNew)
	{
		$sectionList = [
			[
				'sectionName' => 'general_information',
				'fieldName' => 'warehouse_id'
			],
		];
		$stocktakingNew->getStocktakingForm()->waitPageToLoad();
		foreach ($sectionList as $section) {
			$stocktakingNew->getStocktakingForm()->openSection($section['sectionName']);
			\PHPUnit_Framework_Assert::assertTrue(
				$stocktakingNew->getStocktakingForm()->getSection($section['sectionName'])->isVisible(),
				'Section ' . $section['sectionName'] . ' is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$stocktakingNew->getStocktakingForm()->getField($section['fieldName'])->isVisible(),
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
		return "Add New Stocktaking Form is available";
	}
}