<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 17:13
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposPosIndex;

class AssertPosDeleteMessage extends AbstractConstraint
{
	const DELETE_MESSAGE = 'Pos was successfully deleted';

	/**
	 * @param WebposPosIndex $webposPosIndex
	 */
	public function processAssert(WebposPosIndex $webposPosIndex)
	{
		$actualMessage = $webposPosIndex->getMessagesBlock()->getSuccessMessage();
		\PHPUnit_Framework_Assert::assertEquals(
			self::DELETE_MESSAGE,
			$actualMessage,
			'Wrong success message is displayed.'
			. "\nExpected: " . self::DELETE_MESSAGE
			. "\nActual: " . $actualMessage
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Pos success delete message is present.';
	}
}