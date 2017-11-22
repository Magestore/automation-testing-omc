<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 10:56
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTakePaymentPopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getTakePaymentPopup()->isVisible(),
			'Take Payment Popup is not closed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Take Payment - Close Take Payment Popup: Pass";
	}
}