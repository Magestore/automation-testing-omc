<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/03/2018
 * Time: 08:01
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks\Search;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSearchedProductIsShownOnStocksList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			1,
			$webposIndex->getManageStockList()->countProductRows(),
			"Manage Stocks - Search - more than 1 product are shown on product list"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$product->getName(),
			$webposIndex->getManageStockList()->getFirstProductName(),
			"Manage Stocks - Search - Product '".$product->getName()."' is not shown on product list"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Manage Stocks - Search - Product is shown on product list";
	}
}