<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/09/2017
 * Time: 16:03
 */

namespace Magento\Webpos\Test\Constraint\Settings\General;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductIsDisplayedInGrid extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $products)
	{
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->checkout();

		foreach ($products as $item) {
			$webposIndex->getCheckoutPage()->search($item);
			sleep(1);
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCheckoutPage()->getFirstProduct()->isVisible(),
				'product ('. $item .') is not in grid'
			);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Pass: Product is displayed';
	}
}