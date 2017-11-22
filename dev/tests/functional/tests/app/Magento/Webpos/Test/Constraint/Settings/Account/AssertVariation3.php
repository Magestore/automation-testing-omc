<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 15:38
 */

namespace Magento\Webpos\Test\Constraint\Settings\Account;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation3 extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getAccount()->getCurrentPasswordErrorMessage()->isVisible(),
			'Frontend-Setting-Account-Blank Password,blank Confirm: current password require message is not showed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getAccount()->getCurrentPasswordErrorMessage()->getText(),
			'Frontend-Setting-Account-Blank Password,blank Confirm: current password Require message is wrong'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getAccount()->getConfirmPasswordErrorMessage()->isVisible(),
			'Frontend-Setting-Account-Blank Password,blank Confirm: confirm password error message is not showed'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'Please enter the same value again.',
			$webposIndex->getAccount()->getConfirmPasswordErrorMessage()->getText(),
			'Frontend-Setting-Account-Blank Password,blank Confirm: confirm password error message is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Frontend-Setting-Account-Blank Password,blank Confirm : Pass";
	}
}