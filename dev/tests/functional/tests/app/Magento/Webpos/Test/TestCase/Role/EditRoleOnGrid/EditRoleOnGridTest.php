<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/02/2018
 * Time: 10:20
 */

namespace Magento\Webpos\Test\TestCase\Role\EditRoleOnGrid;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class EditRoleOnGridTest extends Injectable
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
	 * @var WebposRole
	 */
	protected $role;

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
	}

	public function test(
		WebposRole $initialRole,
		WebposRole $editRole,
		$action = ''
	)
	{
		$initialRole->persist();
		$this->role = $initialRole;

		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getRoleGrid()->search(['display_name' => $initialRole->getDisplayName()]);
		$this->webposRoleIndex->getRoleGrid()->clickFirstRowToEdit();

	}

//	public function tearDown()
//	{
//		$this->webposRoleIndex->open();
//		$this->webposRoleIndex->getRoleGrid()->massaction()
//	}
}