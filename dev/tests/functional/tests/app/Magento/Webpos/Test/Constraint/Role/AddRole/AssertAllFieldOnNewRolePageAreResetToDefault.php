<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 10:29
 */

namespace Magento\Webpos\Test\Constraint\Role\AddRole;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertAllFieldOnNewRolePageAreResetToDefault extends AbstractConstraint
{
	public function processAssert(WebposRoleNew $webposRoleNew)
	{
		$formData = $webposRoleNew->getRoleForm()->getData();
		\PHPUnit_Framework_Assert::assertEmpty(
			$formData['display_name'],
			"New Role Page - Display name is not empty"
		);

		\PHPUnit_Framework_Assert::assertEmpty(
			$formData['maximum_discount_percent'],
			"New Role Page - Maximum Discount Percent is not empty"
		);
		\PHPUnit_Framework_Assert::assertEmpty(
			$formData['description'],
			"New Role Page - Description is not empty"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Custom',
			$formData['all'],
			"New Role Page - Resource Access is wrong"
		);

		\PHPUnit_Framework_Assert::assertEmpty(
			$formData['resource'],
			"New Role Page - Resources is not empty"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "New role page - all fields reset to default";
	}
}