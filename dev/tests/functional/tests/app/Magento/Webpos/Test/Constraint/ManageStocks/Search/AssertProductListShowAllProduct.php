<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/03/2018
 * Time: 10:07
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\Search;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductListShowAllProduct extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
	    $webposIndex->getManageStockList()->waitForProductListShow();
		\PHPUnit_Framework_Assert::assertGreaterThan(
			1,
			$webposIndex->getManageStockList()->countProductRows(),
			"Manage stocks - Product list is not showing all product"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage stocks - Product list is showing all product";
	}
}