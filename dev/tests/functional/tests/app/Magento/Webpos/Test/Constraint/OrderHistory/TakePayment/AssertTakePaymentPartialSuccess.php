<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 16:10
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTakePaymentPartialSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $result)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getTakePaymentPopup()->isVisible(),
			'Take Payment Popup is not closed'
		);
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Success Message is not displayed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'Create payment successfully!',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Success message's Content is Wrong"
		);

		sleep(10);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentButton()->isVisible(),
			'Take Payment Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float) $result['total-paid'],
			(float) $webposIndex->getOrdersHistory()->getTotalPaid(),
			"Total Paid is not updated"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTotalDueContainer()->isVisible(),
			'Total Due is not displayed on detail page'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float)$result['remain-money'],
			(float) $webposIndex->getOrdersHistory()->getTotalDue(),
			'Total Due is not updated'
		);

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'Create payment successfully!',
			$webposIndex->getNotification()->getFirstNotificationText(),
			'Notification Content is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Take payment - Create Payment Partial: Success";
	}
}