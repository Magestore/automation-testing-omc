<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 15:46
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleMassDeleteNotInGrid extends AbstractConstraint
{
	/**
	 * @param WebposRoleIndex $webposRoleIndex
	 * @param AssertRoleNotInGrid $assertRoleNotInGrid
	 * @param $webposRoleQtyToDelete
	 * @param $roles
	 */
	public function processAssert(
		WebposRoleIndex $webposRoleIndex,
		AssertRoleNotInGrid $assertRoleNotInGrid,
		$webposRoleQtyToDelete,
		$roles
	) {
		for ($i = 0; $i < $webposRoleQtyToDelete; $i++) {
			$assertRoleNotInGrid->processAssert($roles[$i], $webposRoleIndex);
		}
	}

	/**
	 * Success message if Roles not in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Deleted roles are absent in Location grid.';
	}
}