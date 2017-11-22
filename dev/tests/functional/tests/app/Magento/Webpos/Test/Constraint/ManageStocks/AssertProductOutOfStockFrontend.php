<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/09/2017
 * Time: 17:12
 */

namespace Magento\Webpos\Test\Constraint\ManageStocks;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductOutOfStockFrontend extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		$webposIndex->open();
		sleep(7);
		$webposIndex->getCheckoutPage()->search($products[0]['sku']);
		\PHPUnit_Framework_Assert::assertNotFalse(
			$webposIndex->getCheckoutPage()->getFirstProductOutOfStockIcon()->isVisible(),
			'MS09 - out of stock icon is not showed'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'out of stock icon is showed';
	}
}