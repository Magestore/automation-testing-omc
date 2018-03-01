<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/1/2018
 * Time: 9:26 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\EditRole;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 * Class WebposManageRolesMR37Test
 * @package Magento\Webpos\Test\TestCase\Role\EditRole
 */
class WebposManageRolesMR37Test extends Injectable
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
     * @param WebposRoleNew $webposRoleNew
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

    /**
     * @param WebposRole $initialRole
     * @param WebposRole $editRole
     * @return array
     * @throws \Exception
     */
    public function test(
        WebposRole $initialRole,
        WebposRole $editRole
    )
    {
        // Create Role
        $initialRole->persist();
        $this->role = $initialRole;

        $filter = ['display_name' => $this->role->getDisplayName()];
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getRoleGrid()->searchAndOpen($filter);
        $this->webposRoleNew->getRoleForm()->fill($editRole);

        $this->webposRoleNew->getFormPageActions()->save();

        return [
            'webposRole' => $editRole
        ];

    }

    /**
     *
     */
    public function tearDown()
    {
        // Delete Role
        $this->objectManager->create('Magento\Webpos\Test\Handler\Role\Curl')->deleteRole($this->role);
    }
}