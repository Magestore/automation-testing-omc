<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/01/2018
 * Time: 11:27
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipAddressAndShipMethodAreBlank extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryOrderViewContent()->getShippingAddressContent()->isVisible(),
			'Ship address is not blank'
		);
		\PHPUnit_Framework_Assert::assertEmpty(
			$webposIndex->getOrderHistoryOrderViewContent()->getShippingMethodContent()->getText(),
			'Ship method is not blank'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Orders History - Payment/Shipping method - Ship Address and Ship Method session are blank";
	}
}