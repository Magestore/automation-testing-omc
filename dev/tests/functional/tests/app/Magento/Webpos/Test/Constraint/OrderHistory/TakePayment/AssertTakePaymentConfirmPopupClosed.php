<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 13:27
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTakePaymentConfirmPopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentPopup()->isVisible(),
			'Take Payment Popup is not displayed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Take Payment Popup - Close Confirm Popup: Pass";
	}
}