<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 15/03/2018
 * Time: 08:07
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\CheckProductList;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductIsShownOnListWithCorrectQty extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $productInfo)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			1,
			$webposIndex->getManageStockList()->countProductRows(),
			"Manage Stocks - Search - more than 1 product are shown on product list"
		);

		$productName = $productInfo['product']->getName();
		\PHPUnit_Framework_Assert::assertEquals(
			$productName,
			$webposIndex->getManageStockList()->getFirstProductName(),
			"Manage Stocks - Search - Product '".$productName."' is not shown on product list"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$productInfo['product']->getSku(),
			$webposIndex->getManageStockList()->getProductSku($productName)->getText(),
			"Manage Stocks - Search - Product '".$productName."' is not shown on product list"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$productInfo['qty'],
			$webposIndex->getManageStockList()->getProductQtyInput($productName)->getValue(),
			"Manage Stocks - Search - Qty of Product '".$productName."' is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Manage Stocks - Search - Product is shown on product list with correct qty';
	}
}