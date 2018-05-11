<?php
/**
 * Created by PhpStorm.
 * User: bo
 * Date: 08/05/2018
 * Time: 08:34
 */

namespace Magento\Webpos\Test\TestCase\Role\CheckGUI;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 *  Testcase MR01-Manage Roles page
 *
 * precondition
 * Go to backend
 *
 * Teststep
 * 1. Go to Sales > Manage Roles
 *
 *Acceptance Criteria
 * -Titles: Role
 *- Buttons: Add Role
 *- The grid with columns: ID, Display name, Description, Action
 *- Mass actions contains: Delete
 *- Filter function
 *
 *
 * Class ManageRoleMR01Test
 * @package Magento\Webpos\Test\TestCase\Role\CheckGUI
 */
class ManageRoleMR01Test extends Injectable
{
    /**
     * Role index Page
     *
     * @var $_roleIndex
     */
    protected $_roleIndex;

    public function __inject(WebposRoleIndex $roleIndex){
        $this->_roleIndex = $roleIndex;
    }

    public function test(){
        $this->_roleIndex->open();
        $this->_roleIndex->getRoleGrid()->waitForGridLoader();
    }
}