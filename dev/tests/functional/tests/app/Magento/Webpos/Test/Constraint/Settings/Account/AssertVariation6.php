<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 16:52
 */

namespace Magento\Webpos\Test\Constraint\Settings\Account;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Constraint\Settings\Login\AssertLoginFailed;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation6 extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex,
		Staff $staff,
		AssertLoginFailed $assertLoginFailed,
		$currentPassword,
		$newPassword)
	{
		while ($webposIndex->getMsWebpos()->getLoader()->isVisible()) {}
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			"Frontend-Setting-Account-correct info : success messsage didn't displayed"
		);
		\PHPUnit_Framework_Assert::assertEquals(
			"Your account is saved successfully!",
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Frontend-Setting-Account-correct info : success messsage is wrong"
		);
		// login by old password
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->logout();
		$webposIndex->getModal()->getOkButton()->click();
		sleep(5);
		$webposIndex->getLoginForm()->fill($staff);
		$webposIndex->getLoginForm()->clickLoginButton();
		$assertLoginFailed->processAssert($webposIndex);
		// login by new password
		$webposIndex->getLoginForm()->fill($staff);
		$webposIndex->getLoginForm()->getPasswordField()->setValue($newPassword);
		$webposIndex->getLoginForm()->clickLoginButton();
		sleep(1);
//		\PHPUnit_Framework_Assert::assertTrue(
//			$webposIndex->getFirstScreen()->isVisible(),
//			'Frontend-Setting-Account-correct info :Login failed'
//		);
		while ($webposIndex->getFirstScreen()->isVisible()) {}
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->isVisible(),
			"Frontend-Setting-Account-correct info :Checkout page isn't showed"
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Frontend-Setting-Account-correct info : Pass";
	}
}