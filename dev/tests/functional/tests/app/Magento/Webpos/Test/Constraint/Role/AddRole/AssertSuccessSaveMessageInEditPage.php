<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 09:44
 */

namespace Magento\Webpos\Test\Constraint\Role\AddRole;


use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertSuccessSaveMessageInEditPage extends AbstractAssertForm
{
	const SUCCESS_MESSAGE = 'Role was successfully saved';

	public function processAssert(WebposRoleNew $webposRoleNew)
	{
		$actualMessage = $webposRoleNew->getMessagesBlock()->getSuccessMessage();
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
		return "Success message is shown on edit role page";
	}
}