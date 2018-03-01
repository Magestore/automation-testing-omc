<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 10:05
 */

namespace Magento\Webpos\Test\Constraint\Role\AddRole;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertInputFieldsAreShownExactlyOnEditPage extends AbstractConstraint
{
	public function processAssert(WebposRoleNew $webposRoleNew, WebposRole $webposRole)
	{
		$formData = $webposRoleNew->getRoleForm()->getData();
		\PHPUnit_Framework_Assert::assertEquals(
			$webposRole->getDisplayName(),
			$formData['display_name'],
			"Edit Role Page - Display name is wrong"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$webposRole->getMaximumDiscountPercent(),
			$formData['maximum_discount_percent'],
			"Edit Role Page - Maximum Discount Percent is wrong"
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$webposRole->getDescription(),
			$formData['description'],
			"Edit Role Page - Description is wrong"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$webposRole->getAll(),
			$formData['all'],
			"Edit Role Page - Resource Access is wrong"
		);

		\PHPUnit_Framework_Assert::assertContains(
			$webposRole->getResource(),
			$formData['resource'],
			"Edit Role Page - Resources is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Role - Edit role form shown info correctly";
	}
}