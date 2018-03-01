<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/03/2018
 * Time: 11:00
 */

namespace Magento\Webpos\Test\TestCase\Role\AddRole;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class WebposAddRoleMR22Test extends Injectable
{
	/**
	 * Role Index page
	 *
	 * @var WebposRoleIndex
	 */
	protected $webposRoleIndex;

	/**
	 * @var WebposRoleNew
	 */
	protected $webposRoleNew;

	/**
	 * @param FixtureFactory $fixtureFactory
	 * @param WebposRoleIndex $webposRoleIndex
	 */
	public function __inject(
		FixtureFactory $fixtureFactory,
		WebposRoleIndex $webposRoleIndex,
		WebposRoleNew $webposRoleNew
	) {
		$this->fixtureFactory = $fixtureFactory;
		$this->webposRoleIndex = $webposRoleIndex;
		$this->webposRoleNew = $webposRoleNew;
	}

	public function test(
		WebposRole $role1,
		WebposRole $role2
	)
	{
		$role1->persist();
		\Zend_Debug::dump($role1->getData());die;

		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getPageActionsBlock()->addNew();

		$role2 = $this->prepareRoleStaff($role1, $role2);
		$this->webposRoleNew->getRoleForm()->fill($role2);

		$this->webposRoleNew->getFormPageActions()->save();
	}

	/**
	 * @param WebposRole $role1
	 * @param WebposRole $role2
	 * @return WebposRole
	 */
	private function prepareRoleStaff(WebposRole $role1, WebposRole $role2)
	{
		$data = $role2->getData();
		$data['role_staff'] = $role1->getStaffId()[0];
		unset($data['staff_id']);
		return $this->fixtureFactory->createByCode('webposRole', ['data' => $data]);

	}
}