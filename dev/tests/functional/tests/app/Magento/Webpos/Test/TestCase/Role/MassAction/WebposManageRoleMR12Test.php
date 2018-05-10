<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 2:44 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\MassAction;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Role\AssertRoleGridWithNoResult;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 *  Mange Role - Mass Action
 * MR11- Delete 1 Staff
 *
 * Precondition
 * Exist at least 1 record on the grid
 *
 * Steps
 * 1. Go to backend > Sales > Manage Roles
 * 2. Tick on checkbox to select 1 Role on the grid
 * 3. Click on Mass action > Delete
 * 4. Click on [OK] button
 *
 * Acceptance
 * 1. Close the confirmation popup
 * 2. Delete the selected staff successfully and show message: "A total of 1 record(s) were deleted."
 *
 * Class WebposManageRoleMR12Test
 * @package Magento\Webpos\Test\TestCase\Role\MassAction
 */
class WebposManageRoleMR12Test extends Injectable
{
    /**
     * Role Grid Page
     *
     * @var $_roleIndex
     */
    protected $_roleIndex;

    protected $assertRoleGridWithNoResult;

    public function __inject(WebposRoleIndex $roleIndex, AssertRoleGridWithNoResult $assertRoleGridWithNoResult)
    {
        $this->_roleIndex = $roleIndex;
        $this->assertRoleGridWithNoResult = $assertRoleGridWithNoResult;
    }

    public function test(FixtureFactory $fixtureFactory, $webposRole)
    {
        $role1 = $fixtureFactory->createByCode('webposRole', ['dataset' => $webposRole]);
        $role1->persist();
        $role2 = $fixtureFactory->createByCode('webposRole', ['dataset' => $webposRole]);
        $role2->persist();
        $this->_roleIndex->open();
        $filters = [
            [
                'display_name' => $role1->getData('display_name')
            ],
            [
                'display_name' => $role2->getData('display_name')
            ]
        ];
        $this->_roleIndex->getRoleGrid()->massAction($filters, 'Delete', true);
        sleep(1);
        $this->_roleIndex->getRoleGrid()->search([
            'display_name' => $role1->getData('display_name')
        ]);
        $this->assertRoleGridWithNoResult->processAssert($this->_roleIndex, $role1);
        sleep(1);
        $this->_roleIndex->getRoleGrid()->search([
            'display_name' => $role2->getData('display_name')
        ]);
        $this->assertRoleGridWithNoResult->processAssert($this->_roleIndex, $role2);

    }
}