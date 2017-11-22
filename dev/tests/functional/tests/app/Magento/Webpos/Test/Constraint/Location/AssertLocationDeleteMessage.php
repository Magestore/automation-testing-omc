<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/09/2017
 * Time: 16:49
 */

namespace Magento\Webpos\Test\Constraint\Location;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertLocationDeleteMessage extends AbstractConstraint
{
	const DELETE_MESSAGE = 'Location was successfully deleted';

	/**
	 * Assert that after delete Location successful delete message appears.
	 *
	 * @param LocationIndex $locationIndex
	 * @return void
	 */
	public function processAssert(LocationIndex $locationIndex)
	{
		$actualMessage = $locationIndex->getMessagesBlock()->getSuccessMessage();
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
		return 'Location success delete message is present.';
	}
}