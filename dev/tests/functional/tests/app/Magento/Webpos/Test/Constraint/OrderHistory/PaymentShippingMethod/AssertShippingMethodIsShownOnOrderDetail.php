<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 09:09
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShippingMethodIsShownOnOrderDetail extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $shipLabel)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			$shipLabel,
			$webposIndex->getOrderHistoryOrderViewContent()->getShippingMethodContent()->getText(),
			'Orders History - Shipping method is not shown on order detail'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Orders History - Shipping method is shown on order detail";
	}
}