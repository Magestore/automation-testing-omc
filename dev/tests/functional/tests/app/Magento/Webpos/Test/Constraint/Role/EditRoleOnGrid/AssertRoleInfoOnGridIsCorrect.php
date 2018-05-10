<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/02/2018
 * Time: 09:43
 */

namespace Magento\Webpos\Test\Constraint\Role\EditRoleOnGrid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleInfoOnGridIsCorrect extends AbstractConstraint
{

	public function processAssert(WebposRoleIndex $webposRoleIndex, WebposRole $role)
	{
		$webposRoleIndex->getRoleGrid()->search([
			'display_name' => $role->getDisplayName(),
		]);
		\PHPUnit_Framework_Assert::assertEquals(
			$role->getDisplayName(),
			$webposRoleIndex->getRoleGrid()->getColumnValue($role->getRoleId(), "Display Name"),
			'Display name of Role '.$role->getRoleId().' on grid is wrong'
		);

		if (empty($role->getDescription())) {
			$descriptionText = '';
		} else {
			$descriptionText = $webposRoleIndex->getRoleGrid()->getColumnValue($role->getRoleId(), "Description");
		}
		\PHPUnit_Framework_Assert::assertEquals(
			$role->getDescription(),
			$descriptionText,
			'Description of Role '.$role->getRoleId().' on grid is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Edit Role on grid - Role info on grid is correct";
	}
}