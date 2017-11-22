<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/10/2017
 * Time: 16:36
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\AddComment;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAddComment extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $comment)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getAddCommentPopupContainer()->isVisible(),
			'Add Comment Popup is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getCancelAddCommentButton()->isVisible(),
			'Add Comment Popup - Cancel button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getSaveCommentButton()->isVisible(),
			'Add Comment Popup - Save button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getCommentInputBox()->isVisible(),
			'Add Comment Popup - Comment Input box is not displayed'
		);

		$webposIndex->getOrdersHistory()->getCancelAddCommentButton()->click();

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAddCommentPopupContainer()->isVisible(),
			'Add Comment Popup is not hide'
		);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		$webposIndex->getOrdersHistory()->getAction('Add Comment')->click();
		$comment = str_replace('%isolation%', rand(1,99999999), $comment);
		$webposIndex->getOrdersHistory()->getCommentInputBox()->setValue($comment);
		$webposIndex->getOrdersHistory()->getSaveCommentButton()->click();

		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Add Comment Popup - message is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Add order comment successfully!',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			'Add Comment Popup - message is not displayed'
		);

		$webposIndex->getNotification()->getNotificationBell()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getNotification()->getFirstNotification()->isVisible(),
			'Notification list is empty'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Add order comment successfully!',
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
		return "Add Comment: Pass";
	}
}
