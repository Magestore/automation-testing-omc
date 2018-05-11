<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/02/2018
 * Time: 10:48
 */

namespace Magento\Webpos\Test\Constraint\Role\EditRoleOnGrid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertEditableRowIsVisible extends AbstractConstraint
{
	public function processAssert(WebposRoleIndex $webposRoleIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getEditableRow()->isVisible(),
			'Edit role on grid - Editable Row is not shown'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getEditableRow()->getCheckbox()->isVisible(),
			"Edit role on grid - Checkbox is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getEditableRow()->getDisplayNameInput()->isVisible(),
			"Edit role on grid - Display name input is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getEditableRow()->getDescriptionInput()->isVisible(),
			"Edit role on grid - Description is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getRoleGrid()->getCancelButton()->isVisible(),
			"Edit role on grid - Cancel button is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getRoleGrid()->getSaveButton()->isVisible(),
			"Edit role on grid - Save button is not shown"
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Edit role on grid - Editable Row is shown";
	}
}