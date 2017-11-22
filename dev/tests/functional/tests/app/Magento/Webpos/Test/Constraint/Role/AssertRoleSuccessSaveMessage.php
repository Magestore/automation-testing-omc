<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 14:24
 */
namespace Magento\Webpos\Test\Constraint\Role;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleSuccessSaveMessage extends AbstractConstraint
{
	const SUCCESS_MESSAGE = 'Role was successfully saved';

	/**
	 * Check Success Save Message for Synonyms.
	 *
	 * @param WebposRoleIndex $webposRoleIndex
	 * @return void
	 */
	public function processAssert(WebposRoleIndex $webposRoleIndex)
	{
		$actualMessage = $webposRoleIndex->getMessagesBlock()->getSuccessMessage();
		\PHPUnit_Framework_Assert::assertEquals(
			self::SUCCESS_MESSAGE,
			$actualMessage,
			'Wrong success message is displayed.'
			. "\nExpected: " . self::SUCCESS_MESSAGE
			. "\nActual: " . $actualMessage
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Assert that success message is displayed.';
	}
}