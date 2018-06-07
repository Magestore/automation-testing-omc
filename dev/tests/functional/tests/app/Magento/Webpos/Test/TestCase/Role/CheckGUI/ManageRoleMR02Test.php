<?php
/**
 * Created by PhpStorm.
 * User: bo
 * Date: 08/05/2018
 * Time: 08:34
 */

namespace Magento\Webpos\Test\TestCase\Role\CheckGUI;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Role\CheckGUI\AssertCheckRoleForm;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 *  Testcase MR02-Manage Roles page
 *
 * precondition
 * Go to backend
 *
 * Teststep
 * 1. Go to Sales > Manage Roles
 * 2. Click on [Add Role] button
 *
 *Acceptance Criteria
 * Display [New Role] page including:
 * Title: New Role
 * There are 3 tabs: General, Permission, Role list
 * General tab including fields: Role name (*), Maximum discount percent (%), Description
 * Permission tab including [Resource Access] field (Custom, All)
 * Role list tab including: a grid of exist Roles and [Search], [Reset filter] button
 * Buttons: Back to register or connect an account, Reset, Save and continue Edit, Save
 *
 *
 * Class ManageRoleMR02Test
 * @package Magento\Webpos\Test\TestCase\Role\CheckGUI
 */
class ManageRoleMR02Test extends Injectable
{
    /**
     * Role index Page
     *
     * @var $_roleIndex
     */
    protected $_roleIndex;
    /**
     * Role New Page
     *
     * @var $_roleNews
     */
    protected $_roleNews;

    public function __inject(WebposRoleIndex $roleIndex, WebposRoleNew $webposRoleNew)
    {
        $this->_roleIndex = $roleIndex;
        $this->_roleNews = $webposRoleNew;
    }

    public function test(AssertCheckRoleForm $assertCheckRoleForm, $tabs)
    {
        $this->_roleIndex->open();
        $this->_roleIndex->getPageActionsBlock()->addNew();
        $this->_roleNews->getRoleForm()->openTab($tabs['general']['name']);
        $assertCheckRoleForm->assertTabRoleFormField($this->_roleNews, $tabs['general']['name'], $tabs['general']['fields']);
        $this->_roleNews->getRoleForm()->openTab($tabs['permission']['name']);
        $assertCheckRoleForm->assertTabRolePermission($this->_roleNews, $tabs['permission']['fields']);
        $this->_roleNews->getRoleForm()->openTab($tabs['permission']['name']);
        $assertCheckRoleForm->assertTabRolePermission($this->_roleNews, $tabs['permission']['fields']);
        $this->_roleNews->getRoleForm()->openTab($tabs['user_section']['name']);
        $this->_roleNews->getRoleForm()->waitForElementVisible('#staff_grid_table');
        sleep(2);
        $assertCheckRoleForm->assertTabStaffList($this->_roleNews, $tabs['user_section']['fields']);
    }
}