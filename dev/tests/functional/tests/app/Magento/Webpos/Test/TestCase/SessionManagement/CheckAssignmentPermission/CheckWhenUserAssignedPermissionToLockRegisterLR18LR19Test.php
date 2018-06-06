<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/2/18
 * Time: 2:30 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermission;

use Magento\Mtf\TestCase\Injectable;
use Magento\User\Test\Fixture\Role;
use Magento\User\Test\Fixture\User;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
use Magento\User\Test\Page\Adminhtml\UserRoleEditRole;
use Magento\User\Test\Page\Adminhtml\UserRoleIndex;
use Magento\User\Test\Page\Adminhtml\UserIndex;
use Magento\User\Test\Page\Adminhtml\UserEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Backend\Test\Page\AdminAuthLogin;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;

/**
 * Class CheckWhenUserAssignedPermissionToLockRegisterLR18LR19Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermission
 * LR18:
 * Precondition and setup steps
 *   LoginTest backend with admin account
 *   Assign Lock Register permission for user (path: Magento Admin Panel > System > Permission > User Roles > Role Resources)
 * Steps
 *   1. LoginTest backend with user that is assigned permission to Lock Register
 *   2. Go to POS page, observe and check permission
 * Acceptance Criteria
 *   2. On the POS page, show Lock/Unlock button and Lock register configuration
 *
 * LR19:
 * Precondition and setup steps
 *   LoginTest backend with admin account
 *   Create backend user and not assigned Lock register  permission to this user
 * Steps
 *   1. LoginTest backend with user that is not assigned permission to Lock Register
 *   2. Go to an any POS detail page, observe and check permission
 * Acceptance Criteria
 *   2. On the POS detail page, hide Lock/Unlock button and Lock register configuration
 */
class CheckWhenUserAssignedPermissionToLockRegisterLR18LR19Test extends Injectable
{
    /* tags */
    const MVP = 'no';
    const TEST_TYPE = 'extended_acceptance_test';
    /* end tags */

    /**
     * UserRoleIndex page.
     *
     * @var UserRoleIndex
     */
    protected $userRoleIndex;

    /**
     * UserRoleEditRole page.
     *
     * @var UserRoleEditRole
     */
    protected $userRoleEditRole;

    /**
     * WebposRoleNew page.
     *
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    /**
     * UserIndex page.
     *
     * @var UserIndex
     */
    protected $userIndex;

    /**
     * UserEdit page.
     *
     * @var UserEdit
     */
    protected $userEditPage;

    /**
     * PosIndex page.
     *
     * @var PosIndex
     */
    protected $posIndex;

    /**
     * PosEdit page.
     *
     * @var PosEdit
     */
    protected $posEdit;

    /**
     * AdminAuthLogin page.
     *
     * @var AdminAuthLogin
     */
    protected $adminAuth;

    /**
     * Dashboard page.
     *
     * @var Dashboard
     */
    protected $dashboard;

    /**
     * Setup data for test.
     *
     * @param UserRoleIndex $userRoleIndex
     * @param UserRoleEditRole $userRoleEditRole
     * @param WebposRoleNew $webposRoleNew
     * @param PosIndex $posIndex
     * @param PosEdit $posEdit
     * @param Dashboard $dashboard
     * @param AdminAuthLogin $adminAuth
     */
    public function __inject(
        UserRoleIndex $userRoleIndex,
        UserRoleEditRole $userRoleEditRole,
        WebposRoleNew $webposRoleNew,
        UserIndex $userIndex,
        UserEdit $userEditPage,
        PosIndex $posIndex,
        PosEdit $posEdit,
        Dashboard $dashboard,
        AdminAuthLogin $adminAuth
    ) {
        $this->userRoleIndex = $userRoleIndex;
        $this->userRoleEditRole = $userRoleEditRole;
        $this->webposRoleNew = $webposRoleNew;
        $this->userIndex = $userIndex;
        $this->userEditPage = $userEditPage;
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
        $this->dashboard = $dashboard;
        $this->adminAuth = $adminAuth;
    }

    /**
     * Runs Create Admin User Role Entity test.
     *
     * @param Role $role
     */
    public function test(
        Role $role,
        User $user,
        $testId
    ) {
        //Steps
        $this->userRoleIndex->open();
        $this->userRoleIndex->getRoleActions()->addNew();
        $this->userRoleEditRole->getRoleFormTabs()->fill($role);
        $this->userRoleEditRole->getRoleFormTabs()->openTab('role-resources');
        if ($testId == 'LR19') {
            $arrs = [
                'Magento_Backend::dashboard',
//                'Magestore_OrderSuccess::all',
                'Magento_Analytics::analytics',
                'Magento_Sales::sales',
                'Magento_Catalog::catalog',
                'Magento_Customer::customer',
                'Magento_Cart::cart',
                'Magento_Backend::myaccount',
                'Magento_Backend::marketing',
                'Magento_Backend::content',
                'Magento_Reports::report',
                'Magento_Backend::stores',
                'Magento_Backend::system',
                'Magento_Backend::global_search',
                'Magestore_Webpos::lock_register'
            ];
            $this->webposRoleNew->getRoleForm()->getRoleResources($arrs);
        }
        $this->userRoleEditRole->getPageActions()->save();

        //Open User R
        $this->userIndex->open();
        $this->userIndex->getPageActions()->addNew();
        $this->userEditPage->getUserForm()->fill($user);
        $this->userEditPage->getPageActions()->save();
    }

    public function tearDown()
    {
        $this->dashboard->getAdminPanelHeader()->logOut();
        $isLoginBlockVisible = $this->adminAuth->getLoginBlock()->isVisible();
        \PHPUnit_Framework_Assert::assertTrue(
            $isLoginBlockVisible,
            'Admin user was not logged out.'
        );
    }
}
