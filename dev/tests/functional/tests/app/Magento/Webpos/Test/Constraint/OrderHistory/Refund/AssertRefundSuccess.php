<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/10/2017
 * Time: 13:39
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $expectStatus, $hideAction, $totalRefunded)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getRefundPopup()->isVisible(),
			'Refund Popup is not closed'
		);
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Success Message is not displayed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'A creditmemo has been created!',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Success message's Content is Wrong"
		);

		sleep(10);

		\PHPUnit_Framework_Assert::assertEquals(
			$expectStatus,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Order Status is wrong'
		);

		if (isset($totalRefunded)) {
			$expectTotalRefunded = $totalRefunded;
		} else {
			$expectTotalRefunded = $webposIndex->getOrdersHistory()->getTotalPaid();
		}
		\PHPUnit_Framework_Assert::assertEquals(
			(float) $expectTotalRefunded,
			(float) $webposIndex->getOrdersHistory()->getTotalRefunded(),
			'Order History - Refund - Total Refunded does not equal Total Paid'
 		);

		$hideActionList = explode(',', $hideAction);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		foreach ($hideActionList as $action) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getOrdersHistory()->getAction($action)->isVisible(),
				'Action '.$action.' is not hiden.'
			);
		}

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'A creditmemo has been created!',
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
		return "Order History - Refund - Submit Refund: Success";
	}
}