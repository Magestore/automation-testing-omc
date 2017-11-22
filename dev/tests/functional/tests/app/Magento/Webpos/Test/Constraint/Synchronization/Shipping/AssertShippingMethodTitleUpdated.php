<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 16:10
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Shipping;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShippingMethodTitleUpdated extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $methodTitle)
	{
		$webposIndex->open();
		$webposIndex->getCheckoutPage()->clickFirstProduct();
		$webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$webposIndex->getCheckoutPage()->clickShippingHeader();
		$name = $webposIndex->getCheckoutPage()->getWebposShippingMethodName();
		$name = explode(' - ', $name)[1];
		\PHPUnit_Framework_Assert::assertEquals(
			$methodTitle,
			$name,
			'Synchronization - Shipping - Webpos Shipping Title is not updated'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Shipping - Shipping Title updated on checkout page";
	}
}