<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/09/2017
 * Time: 13:56
 */

namespace Magento\Webpos\Test\Constraint\Settings\Account;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertEditDisplayName extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex,StaffIndex $staffIndex, $displayName)
	{

		while ($webposIndex->getMsWebpos()->getLoader()->isVisible()) {}
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			"Edit Display name - success messsage didn't displayed"
		);
		\PHPUnit_Framework_Assert::assertEquals(
			"Your account is saved successfully!",
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Edit Display name - success messsage is wrong"
		);

		$webposIndex->getMsWebpos()->clickCMenuButton();
		\PHPUnit_Framework_Assert::assertEquals(
			$displayName,
			$webposIndex->getCMenu()->getUsername(),
			"Edit Display name - display name is not updated in C Menu"
		);

		$staffIndex->open();
		$filter = ['display_name' => $displayName];
		\PHPUnit_Framework_Assert::assertTrue(
			$staffIndex->getStaffsGrid()->isRowVisible($filter, true, false),
			"Edit Display name - display name is not updated in backend"
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Display name updated";
	}
}