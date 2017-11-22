<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 14:49
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleDeleteMessage extends AbstractConstraint
{
	const DELETE_MESSAGE = 'Role was successfully deleted';

	/**
	 * Assert that after delete Location successful delete message appears.
	 *
	 * @param WebposRoleIndex $webposRoleIndex
	 * @return void
	 */
	public function processAssert(WebposRoleIndex $webposRoleIndex)
	{
		$actualMessage = $webposRoleIndex->getMessagesBlock()->getSuccessMessage();
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
		return 'Role success delete message is present.';
	}
}