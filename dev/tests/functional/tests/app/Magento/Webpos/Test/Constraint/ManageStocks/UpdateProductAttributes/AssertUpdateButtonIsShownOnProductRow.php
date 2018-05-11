<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/03/2018
 * Time: 09:05
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertUpdateButtonIsShownOnProductRow
 * @package Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes
 */
class AssertUpdateButtonIsShownOnProductRow extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $productInfo
	 */
	public function processAssert(WebposIndex $webposIndex, $productInfo)
	{
		$productName = $productInfo['product']->getName();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getManageStockList()->getUpdateButton($productName)->isVisible(),
			"Manage Stocks - Update button is not shown on product '".$productName."'row"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Update button is shown on product row";
	}
}