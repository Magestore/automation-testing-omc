<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 15:42
 */

namespace Magento\Webpos\Test\Constraint\Role;



use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleMassDeleteInGrid extends AbstractConstraint
{
	/**
	 * @param WebposRoleIndex $webposRoleIndex
	 * @param AssertRoleInGrid $assertRoleInGrid
	 * @param $webposRoleQtyToDelete
	 * @param $roles
	 */
	public function processAssert(
		WebposRoleIndex $webposRoleIndex,
		AssertRoleInGrid $assertRoleInGrid,
		$webposRoleQtyToDelete,
		$roles
	) {
		$roles = array_slice($roles, $webposRoleQtyToDelete);
		foreach ($roles as $item) {
			$assertRoleInGrid->processAssert($item, $webposRoleIndex);
		}
	}

	/**
	 * Text success exist Roles in grid
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Roles are present in Location grid.';
	}
}