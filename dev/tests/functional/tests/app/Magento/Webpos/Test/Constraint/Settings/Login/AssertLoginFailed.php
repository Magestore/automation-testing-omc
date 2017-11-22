<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 15:34
 */

namespace Magento\Webpos\Test\Constraint\Settings\Login;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLoginFailed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			"warning messsage didn't displayed"
		);
		\PHPUnit_Framework_Assert::assertEquals(
			"Your login information is wrong!",
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"warning messsage didn't displayed"
		);
		sleep(5);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getFirstScreen()->isVisible(),
			'incorrect account - Login success'
		);
	}

	/**
	 * Text success save message is displayed
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Login failed';
	}
}