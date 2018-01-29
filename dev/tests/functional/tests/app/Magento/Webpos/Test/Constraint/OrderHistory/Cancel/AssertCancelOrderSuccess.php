<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 10:56
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCancelOrderSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryAddCancelComment()->isVisible(),
			'Cancel Popup is not closed'
		);
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Success Message is not displayed'
		);
		$message = 'The order has been canceled successfully.';
		\PHPUnit_Framework_Assert::assertEquals(
			$message,
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Success message's Content is Wrong"
		);

		$expectStatus = 'Cancelled';
		sleep(3);
		\PHPUnit_Framework_Assert::assertEquals(
			$expectStatus,
			$webposIndex->getOrderHistoryOrderViewHeader()->getStatus(),
			'Order Status is wrong'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
			'Order History - Cancel Order - Take payment button is not hide'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->isVisible(),
			'Order History - Cancel Order - Invoice button is not hide'
		);

		$hideActionList = [
			'Send Email',
			'Ship',
			'Cancel',
			'Refund'
		];

		$webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
		foreach ($hideActionList as $action) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getOrderHistoryOrderViewHeader()->getAction($action)->isVisible(),
				'Action '.$action.' is not hiden.'
			);
		}

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$message,
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