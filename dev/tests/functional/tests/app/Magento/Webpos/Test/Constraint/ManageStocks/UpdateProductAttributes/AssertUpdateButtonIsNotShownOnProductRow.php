<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/03/2018
 * Time: 09:32
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertUpdateButtonIsNotShownOnProductRow extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $productInfo)
	{
		$productName = $productInfo['product']->getName();
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getManageStockList()->getUpdateButton($productName)->isVisible(),
			"Manage Stocks - Update button is still shown on product '".$productName."'row"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Update button is not shown on product row";
	}
}