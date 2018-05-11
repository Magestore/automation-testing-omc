<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 11:12
 */

namespace Magento\Webpos\Test\Constraint\Role\AddRole;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertStaffIsAssignedToRole extends AbstractConstraint
{
	public function processAssert(StaffIndex $staffIndex, WebposRole $role, $staffId)
	{
		$staffIndex->open();

		$staffIndex->getStaffsGrid()->search([
			'staff_id[from]' => $staffId,
			'staff_id[to]' => $staffId
		]);

		\PHPUnit_Framework_Assert::assertEquals(
			$role->getDisplayName(),
			$staffIndex->getStaffsGrid()->getColumnValue($staffId, 'Role'),
			"Staff ".$staffId."is not assigned to roll ".$role->getDisplayName()
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Add role - staff is assigned to role";
	}
}