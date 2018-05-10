<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/02/2018
 * Time: 08:47
 */

namespace Magento\Webpos\Test\Constraint\Role\EditRoleOnGrid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleSuccessEditMessage extends AbstractConstraint
{
	const SUCCESS_MESSAGE = 'You have successfully saved your edits.';

	public function processAssert(WebposRoleIndex $webposRoleIndex)
	{
		$actualMessage = $webposRoleIndex->getRoleGrid()->getRowEditMessage()->getText();
		\PHPUnit_Framework_Assert::assertEquals(
			self::SUCCESS_MESSAGE,
			$actualMessage,
			'Wrong success message is displayed.'
			. "\nExpected: " . self::SUCCESS_MESSAGE
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
		return "Edit Role on grid - Success edit message is shown";
	}
}