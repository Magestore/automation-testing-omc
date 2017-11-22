<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 15:47
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleNotInGrid extends AbstractConstraint
{
	/**
	 * @param WebposRole $webposRole
	 * @param WebposRoleIndex $webposRoleIndex
	 */
	public function processAssert(
		WebposRole $webposRole,
		WebposRoleIndex $webposRoleIndex
	) {
		$webposRoleIndex->open();
		\PHPUnit_Framework_Assert::assertFalse(
			$webposRoleIndex->getRoleGrid()->isRowVisible(['display_name' => $webposRole->getDisplayName()]),
			'Role with name ' . $webposRole->getDisplayName() . 'is present in Role grid.'
		);
	}

	/**
	 * Success message if Role not in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Role is absent in Location grid.';
	}
}