<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/03/2018
 * Time: 11:11
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\Search;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductListIsEmpty extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getManageStockList()->getFirstProductRow()->isVisible(),
			'Manage Stocks - Search - Product list is not empty'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Product list is empty";
	}
}