<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 16:13
 */

namespace Magento\Webpos\Test\Constraint\Settings\Account;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;


class AssertVariation5 extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getAccount()->getPasswordErrorMessage()->isVisible(),
			'Frontend-Setting-Account-CurrentPass(correct),NewPassword(3 characters) : new password error message is not showed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'Please enter 7 or more characters, using both numeric and alphabetic.',
			$webposIndex->getAccount()->getPasswordErrorMessage()->getText(),
			'Frontend-Setting-Account-CurrentPass(correct),NewPassword(3 characters) : new password error message is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Frontend-Setting-Account-CurrentPass(correct),NewPassword(3 characters) : Pass";
	}
}