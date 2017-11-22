<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/11/2017
 * Time: 14:45
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Currency;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCurrencyIsUsedInCheckoutPage extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $currency, $rate, $symbol, $action = "")
	{
		$webposIndex->open();
		\PHPUnit_Framework_Assert::assertContains(
			$symbol,
			$webposIndex->getCheckoutPage()->getTotal(),
			'Synchronization - Currency - '.$action.' - Currency is not used in checkout page'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Currency - Currency is used in checkout page";
	}
}