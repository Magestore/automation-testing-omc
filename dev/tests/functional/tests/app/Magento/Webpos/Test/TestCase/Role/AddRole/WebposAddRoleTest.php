<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/02/2018
 * Time: 10:46
 */

namespace Magento\Webpos\Test\TestCase\Role\AddRole;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class WebposAddRoleTest extends Injectable
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
		WebposRoleIndex $webposRoleIndex,
		WebposRoleNew $webposRoleNew
	) {
		$this->fixtureFactory = $fixtureFactory;
		$this->webposRoleIndex = $webposRoleIndex;
		$this->webposRoleNew = $webposRoleNew;
	}

	public function test(
		WebposRole $webposRole = null,
		$action = ''
	)
	{
		$this->webposRoleIndex->open();
		$this->webposRoleIndex->getPageActionsBlock()->addNew();

		if (isset($webposRole)) {
			$this->webposRoleNew->getRoleForm()->fill($webposRole);
		}

		if ($action === 'save') {
			$this->webposRoleNew->getFormPageActions()->save();
		}
	}
}