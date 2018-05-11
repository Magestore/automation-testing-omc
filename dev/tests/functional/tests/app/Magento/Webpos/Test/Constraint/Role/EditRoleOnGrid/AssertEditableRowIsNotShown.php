<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/02/2018
 * Time: 08:35
 */

namespace Magento\Webpos\Test\Constraint\Role\EditRoleOnGrid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class AssertEditableRowIsNotShown extends AbstractConstraint
{
	public function processAssert(WebposRoleIndex $webposRoleIndex)
	{
		$webposRoleIndex->getRoleGrid()->waitForGridLoader();

		\PHPUnit_Framework_Assert::assertFalse(
			$webposRoleIndex->getEditableRow()->isVisible(),
			"Edit Role on grid - Editable Row is not hided"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Edit Role on grid - Editable Row is hided";
	}
}