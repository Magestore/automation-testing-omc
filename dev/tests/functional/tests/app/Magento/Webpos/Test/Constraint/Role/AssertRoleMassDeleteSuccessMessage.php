<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 15:39
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleMassDeleteSuccessMessage extends AbstractConstraint
{
	/**
	 * Message that appears after deletion via mass actions
	 */
	const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) were deleted.';

	/**
	 * Assert that message "A total of "x" record(s) were deleted."
	 *
	 * @param $webposRoleQtyToDelete
	 * @param WebposRoleIndex $webposRoleIndex
	 * @return void
	 */
	public function processAssert($webposRoleQtyToDelete, WebposRoleIndex $webposRoleIndex)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			sprintf(self::SUCCESS_DELETE_MESSAGE, $webposRoleQtyToDelete),
			$webposRoleIndex->getMessagesBlock()->getSuccessMessage(),
			'Wrong delete message is displayed.'
		);
	}

	/**
	 * Returns a string representation of the object
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Mass delete roles message is displayed.';
	}
}