<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 10:37
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTakePaymentPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentPopup()->isVisible(),
			'Take Payment popup is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentCancelButton()->isVisible(),
			'Take Payment popup - Cancel button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentHeaderSubmitAction()->isVisible(),
			'Take Payment popup - Submit action on popup header is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentAddMorePaymentButton()->isVisible(),
			'Take Payment popup - Add More Payment method button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentSubmitButton()->isVisible(),
			'Take Payment popup - Submit button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentPaymentList()->isVisible(),
			'Take Payment popup - Payment List is not displayed'
		);


	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Take Payment - Popup Display: Pass";
	}
}