<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/10/2017
 * Time: 16:15
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Product;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductUpdateSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $action = '')
	{
		$productText = "Product";
		$stockText = "Stock Item";
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getItemRowProgress($productText)->isVisible(),
			"Synchronization - Product - ".$action." - Product's progress bar is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getItemRowProgress($stockText)->isVisible(),
			"Synchronization - Product - ".$action." - Stock's progress bar is not shown"
		);

		while ($webposIndex->getSynchronization()->getItemRowProgress($productText)->isVisible()){}
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getItemRowSuccess($productText)->isVisible(),
			"Synchronization - Product - ".$action." - Product's success icon is not shown"
		);

		while ($webposIndex->getSynchronization()->getItemRowProgress($stockText)->isVisible()){}
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getSynchronization()->getItemRowSuccess($stockText)->isVisible(),
			"Synchronization - Product - ".$action." - Stock's success icon is not shown"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Update Product Success - Stock is auto update at the same time: Success";
	}
}