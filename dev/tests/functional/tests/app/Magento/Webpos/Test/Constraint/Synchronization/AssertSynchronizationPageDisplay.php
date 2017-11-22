<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 26/10/2017
 * Time: 14:12
 */

namespace Magento\Webpos\Test\Constraint\Synchronization;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSynchronizationPageDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->isVisible(),
			'Synchronization - Synchronization page is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getUpdateAllButton()->isVisible(),
			'Synchronization - Update All Button is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getReloadAllButton()->isVisible(),
			'Synchronization - Reload All Button is not shown'
		);
		$itemList = [
			'Swatch Option',
			'Configuration',
			'Category',
			'Product',
			'Stock Item',
			'Shift',
			'Group',
			'Customer Complaints',
			'Customer',
			'Currency',
			'Country',
			'Order',
			'Payment',
			'Shipping',
			'Tax Rate',
			'Tax Classes',
			'Tax rule'
		];
		foreach ($itemList as $item) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getSynchronization()->getItemRow($item)->isVisible(),
				"Synchronization - Item ".$item."is not shown"
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getSynchronization()->getItemRowUpdateButton($item)->isVisible(),
				'Synchronization - Update button of "'.$item.'" is not shown'
			);
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getSynchronization()->getItemRowReloadButton($item)->isVisible(),
				'Synchronization - Reload button of "'.$item.'" is not shown'
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
		return "Synchronization Page is display correctly";
	}
}