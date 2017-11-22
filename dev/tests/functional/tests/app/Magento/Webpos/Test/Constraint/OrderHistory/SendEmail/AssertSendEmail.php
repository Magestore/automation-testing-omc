<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/10/2017
 * Time: 14:39
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\SendEmail;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSendEmail extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getSendEmailPopupContainer()->isVisible(),
			'Send Email Popup is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getCancelSendEmailButton()->isVisible(),
			'Send Email Popup - Cancel button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getSendButton()->isVisible(),
			'Send Email Popup - Send button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getEmailInputBox()->isVisible(),
			'Send Email Popup - Email Input box is not displayed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'guest@example.com',
			$webposIndex->getOrdersHistory()->getEmailInputBox()->getValue(),
			'Email is not automatically inserted '
		);

		$webposIndex->getOrdersHistory()->getCancelSendEmailButton()->click();

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getSendEmailPopupContainer()->isVisible(),
			'Send Email Popup is not hide'
		);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		$webposIndex->getOrdersHistory()->getAction('Send Email')->click();
		$webposIndex->getOrdersHistory()->getSendButton()->click();

		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Send Email Popup - message is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'An email has been sent for this order!',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			'Send Email Popup - message is not displayed'
		);

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'An email has been sent for this order!',
			$webposIndex->getNotification()->getFirstNotificationText(),
			'Notify content is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Send Email: Pass";
	}
}