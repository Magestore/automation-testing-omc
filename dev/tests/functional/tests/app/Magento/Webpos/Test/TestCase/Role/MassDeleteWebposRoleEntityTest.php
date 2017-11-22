<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/09/2017
 * Time: 15:33
 */

namespace Magento\Webpos\Test\TestCase\Role;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class MassDeleteWebposRoleEntityTest extends Injectable
{
	/**
	 * Role Index page
	 *
	 * @var WebposRoleIndex
	 */
	protected $webposRoleIndex;


	/**
	 * Factory for fixture
	 *
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @param FixtureFactory $fixtureFactory
	 * @param WebposRoleIndex $webposRoleIndex
	 */
	public function __inject(
		FixtureFactory $fixtureFactory,
		WebposRoleIndex $webposRoleIndex
	) {
		$this->fixtureFactory = $fixtureFactory;
		$this->webposRoleIndex = $webposRoleIndex;
//		$locationIndex->open();
//		$locationIndex->getLocationGrid()->massaction([], 'Delete', true, 'Select All');
	}

	/**
	 * @param $webposRoleQty
	 * @param $webposRoleQtyToDelete
	 * @return array
	 */
	public function test($webposRoleQty, $webposRoleQtyToDelete)
	{
		// Preconditions:
		$roles = $this->createRole($webposRoleQty);
		$deleteRole = [];
		for ($i = 0; $i < $webposRoleQtyToDelete; $i++) {
			$deleteRole[] = ['display_name' => $roles[$i]->getDisplayName()];
		}
		// Steps:
		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getRoleGrid()->massaction($deleteRole, 'Delete', true);

		return ['roles' => $roles];
	}

	/**
	 * @param $webposRoleQty
	 * @return array
	 */
	protected function createRole($webposRoleQty)
	{
		$roles = [];
		for ($i = 0; $i < $webposRoleQty; $i++) {
			$webposRole = $this->fixtureFactory->createByCode('webposRole', ['dataset' => 'default']);
			$webposRole->persist();
			$roles[] = $webposRole;
		}

		return $roles;
	}
}
