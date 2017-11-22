<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 17:07
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Shipping;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShippingMethodPriceUpdated extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $price)
	{
		$webposIndex->open();
		$webposIndex->getCheckoutPage()->clickFirstProduct();
		$webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$webposIndex->getCheckoutPage()->clickShippingHeader();
		\PHPUnit_Framework_Assert::assertEquals(
			(float) $price,
			(float) $webposIndex->getCheckoutPage()->getWebposShippingMethodPrice(),
			'Synchronization - Shipping - Webpos Shipping Price is not updated'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Shipping - Shipping Price updated on checkout page";
	}
}