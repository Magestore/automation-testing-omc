<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 09:43
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Shipment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertShipmentCustomProduct extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $orderId)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			$orderId,
			$webposIndex->getOrdersHistory()->getOrderId(),
			'Order Id in order detail is wrong'
		);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Ship')->isVisible(),
			'Action Box - Ship Action is still displayed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Shipment - Custom Product: Pass";
	}
}