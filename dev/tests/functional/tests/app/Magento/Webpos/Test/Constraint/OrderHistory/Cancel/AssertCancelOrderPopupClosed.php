<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 16:00
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCancelOrderPopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $expectStatus)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getCancelOrderPopup()->isVisible(),
			'Cancel Order Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$expectStatus,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Order Status is changed'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Cancel Order - Popup close: Success";
	}
}