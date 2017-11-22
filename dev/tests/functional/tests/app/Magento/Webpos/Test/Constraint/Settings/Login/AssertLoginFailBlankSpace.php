<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 14:32
 */

namespace Magento\Webpos\Test\Constraint\Settings\Login;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLoginFailBlankSpace extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getLoginForm()->getUsernameErrorMessage()->isVisible(),
			'Username require message is not showed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getLoginForm()->getPasswordErrorMessage()->isVisible(),
			'Password require message is not showed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getLoginForm()->getUsernameErrorMessage()->getText(),
			'Username Require message is wrong'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getLoginForm()->getPasswordErrorMessage()->getText(),
			'Password Require message is wrong'
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'error field displayed';
	}
}