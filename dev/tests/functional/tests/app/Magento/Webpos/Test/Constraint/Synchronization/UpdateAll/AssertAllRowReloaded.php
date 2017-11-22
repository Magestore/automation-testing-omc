<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 26/10/2017
 * Time: 14:45
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\UpdateAll;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAllRowReloaded extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex
	)
	{
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
				$webposIndex->getSynchronization()->getItemRowProgress($item)->isVisible(),
				"Synchronization - Item ".$item."'s loading progress bar is not shown"
			);
		}
		$check = false;
		while (!$check) {
			foreach ($itemList as $item) {
				$check = $webposIndex->getSynchronization()->getItemRowSuccess($item)->isVisible();
			}
		}
		\PHPUnit_Framework_Assert::assertTrue(
			$check,
			"Synchronization - Items's success icon is not shown"
		);
		sleep(10);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Update All - All Row reloaded";
	}
}