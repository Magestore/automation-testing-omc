<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 09:00
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAddShippingAddressPopupIsClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getCheckoutAddShippingAddress()->isVisible(),
			"Customer on checkout page - Shipping address popup - Shipping address popup is not closed"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->isVisible(),
			"Customer on checkout page - Shipping address popup - New customer popup is not shown"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Shipping address popup is closed";
	}
}