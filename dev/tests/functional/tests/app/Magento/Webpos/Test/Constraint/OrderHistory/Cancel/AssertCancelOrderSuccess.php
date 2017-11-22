<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 16:50
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCancelOrderSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $expectStatus)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getCancelOrderPopup()->isVisible(),
			'Cancel Popup is not closed'
		);

		sleep(10);
		\PHPUnit_Framework_Assert::assertEquals(
			$expectStatus,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Status after cancelled is wrong'
		);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Send Email')->isVisible(),
			'Action Box - Send Email acion is not hided'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Ship')->isVisible(),
			'Action Box - Ship acion is not hided'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Cancel')->isVisible(),
			'Action Box - Cancel acion is not hided'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Refund')->isVisible(),
			'Action Box - Refund acion is not hided'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getTakePaymentButton()->isVisible(),
			'Take Payment Button is not hided'
		);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getInvoiceButton()->isVisible(),
			'Invoice Button is not hided'
		);

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'The order has been canceled successfully.',
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
		return "Order History - Cancel Order success";
	}
}