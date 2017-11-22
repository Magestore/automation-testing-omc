<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 14:26
 */

namespace Magento\Webpos\Test\Constraint\Role;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertRoleInGrid extends AbstractConstraint
{
	/**
	 * @param WebposRole $webposRole
	 * @param WebposRoleIndex $webposRoleIndex
	 */
	public function processAssert(WebposRole $webposRole, WebposRoleIndex $webposRoleIndex)
	{
		$webposRoleIndex->open();
		$data = $webposRole->getData();
		$filter = [
			'display_name' => $data['display_name'],
		];

		$webposRoleIndex->getRoleGrid()->search($filter);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposRoleIndex->getRoleGrid()->isRowVisible($filter, false, false),
			'Role with '
			. 'display name \'' . $filter['display_name'] . '\', '
			. 'is absent in Role grid.'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Role is present in grid.';
	}
}