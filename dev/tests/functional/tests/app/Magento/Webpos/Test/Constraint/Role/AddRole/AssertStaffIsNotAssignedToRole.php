<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 11:12
 */

namespace Magento\Webpos\Test\Constraint\Role\AddRole;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Repository\WebposRole;

class AssertStaffIsNotAssignedToRole extends AbstractConstraint
{
	public function processAssert(WebposRoleIndex $webposRoleIndex, WebposRole $role, $staffId)
	{
		
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Add role - staff is not assign to role";
	}
}