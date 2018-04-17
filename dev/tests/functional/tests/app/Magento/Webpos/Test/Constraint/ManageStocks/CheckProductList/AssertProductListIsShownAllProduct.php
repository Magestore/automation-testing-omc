<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 14/03/2018
 * Time: 07:53
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\CheckProductList;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductListIsShownAllProduct extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $productList)
	{
		foreach ($productList as $item) {

			$productName = $item['product']->getName();

			if (isset($item['qty'])) {
				\PHPUnit_Framework_Assert::assertEquals(
					$item['qty'],
					$webposIndex->getManageStockList()->getProductQtyInput($productName)->getValue(),
					"Manage Stocks - qty of product '".$productName."' is wrong"
				);
			}
			if (isset($item['inStock'])) {
				$inStockCheckbox = $webposIndex->getManageStockList()->getProductInStockCheckbox($productName);
				if ($item['inStock']) {
					\PHPUnit_Framework_Assert::assertGreaterThanOrEqual(
						0,
						$webposIndex->getManageStockList()->isCheckboxChecked($inStockCheckbox),
						"Manage Stocks - instock field of product '".$productName."' is wrong"
					);
				} else {
					\PHPUnit_Framework_Assert::assertFalse(
						$webposIndex->getManageStockList()->isCheckboxChecked($inStockCheckbox),
						"Manage Stocks - instock field of product '".$productName."' is wrong"
					);
				}
			}
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Product list is shown all product";
	}
}