<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/03/2018
 * Time: 09:12
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertManageStocksPageIsDisplayedCorrectly extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->isVisible(),
			"Manage Stocks page is not shown"
		);

		$firstProductName = $webposIndex->getManageStockList()->getFirstProductName();
		\PHPUnit_Framework_Assert::assertNotEmpty(
			$firstProductName,
			"Manage Stocks - Product list is empty"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getProductName($firstProductName)->isVisible(),
			'Manage Stocks - Product name is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getProductSku($firstProductName)->isVisible(),
			'Manage Stocks - Product SKU is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getProductQtyInput($firstProductName)->isVisible(),
			'Manage Stocks - Product Qty Input is not shown'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getManageStockList()->getProductQtyInput($firstProductName)->isDisabled(),
			'Manage Stocks - Product Qty Input is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getProductInStockCheckbox($firstProductName)->isVisible(),
			'Manage Stocks - Product In Stock Switch case is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getProductManageStocksCheckbox($firstProductName)->isVisible(),
			'Manage Stocks - Product Manage Stocks Switch case is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getProductBackOrdersCheckbox($firstProductName)->isVisible(),
			'Manage Stocks - Product Backorders Switch case is not shown'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getUpdateAllButton()->isVisible(),
			'Manage Stocks - Update All Button is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Webpos - Manage Stocks is displayed correctly";
	}
}