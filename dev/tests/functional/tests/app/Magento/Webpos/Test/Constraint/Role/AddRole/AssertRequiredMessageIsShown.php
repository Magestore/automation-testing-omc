<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/02/2018
 * Time: 11:11
 */

namespace Magento\Webpos\Test\Constraint\Role\AddRole;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 * Class AssertRequiredMessageIsShown
 * @package Magento\Webpos\Test\Constraint\Role\AddRole
 */
class AssertRequiredMessageIsShown extends AbstractConstraint
{

	const REQUIRE_MESSAGE = 'This is a required field.';

	/**
	 * @param WebposRoleNew $webposRoleNew
	 */
	public function processAssert(WebposRoleNew $webposRoleNew)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleNew->getRoleForm()->getDisplayNameError()->isVisible(),
			"Add Role - Require message is not shown"
		);
		$actualMessage = $webposRoleNew->getRoleForm()->getDisplayNameError()->getText();

		\PHPUnit_Framework_Assert::assertEquals(
			self::REQUIRE_MESSAGE,
			$actualMessage,
			'Require message is wrong'
			. "\nExpected: " . self::REQUIRE_MESSAGE
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
		return "Add Role - Require message is shown";
	}
}