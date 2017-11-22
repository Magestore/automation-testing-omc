<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 30/10/2017
 * Time: 15:32
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Group;


use Magento\Customer\Test\Fixture\CustomerGroup;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerGroupIsInGroupList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, CustomerGroup $customerGroup, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->customerList();
		sleep(1);
		$webposIndex->getCustomerListContainer()->clickAddNew()->click();
		$webposIndex->getCustomerListContainer()->getCustomerGroupSelectBox()->click();
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCustomerListContainer()->getCustomerGroupItem($customerGroup->getCustomerGroupCode())->isVisible(),
			'Synchronization - Group - '.$action.' - Customer Group "'.$customerGroup->getCustomerGroupCode().'" is not shown in Group List'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Group - Created Group is shown on Group List";
	}
}
