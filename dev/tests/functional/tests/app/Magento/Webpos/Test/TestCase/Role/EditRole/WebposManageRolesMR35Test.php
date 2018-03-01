<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 11:10 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\EditRole;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

class WebposManageRolesMR35Test extends Injectable
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
     * @param WebposRoleIndex $webposRoleIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposRoleIndex $webposRoleIndex,
        FixtureFactory $fixtureFactory
    ) {
        $this->webposRoleIndex = $webposRoleIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test(
        WebposRole $initialRole
    )
    {
        // Create Role
        $initialRole->persist();
        $this->role = $initialRole;

        $filter = ['display_name' => $this->role->getDisplayName()];
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getRoleGrid()->searchAndOpen($filter);

        return [
            'role' => $this->role
        ];

    }

	public function tearDown()
	{
        // Delete Role
        $this->objectManager->create('Magento\Webpos\Test\Handler\Role\Curl')->deleteRole($this->role);
	}
}