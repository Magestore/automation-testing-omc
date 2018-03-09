<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/03/2018
 * Time: 09:33
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertUpdateButtonsOfProductsAreNotShown
 * @package Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes
 */
class AssertUpdateButtonsOfProductsAreNotShown extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param AssertUpdateButtonIsNotShownOnProductRow $assertUpdateButtonIsNotShownOnProductRow
	 * @param $productList
	 */
	public function processAssert(
		WebposIndex $webposIndex,
		AssertUpdateButtonIsNotShownOnProductRow $assertUpdateButtonIsNotShownOnProductRow,
		$productList
	)
	{
		foreach ($productList as $item) {
			$assertUpdateButtonIsNotShownOnProductRow->processAssert($webposIndex, $item);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Update buttons are not shown on products row";
	}
}