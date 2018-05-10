<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/9/18
 * Time: 2:44 PM
 */

namespace Magento\Webpos\Test\TestCase\Role\MassAction;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;

/**
 *  Mange Role - Mass Action
 * MR10- Delete Staff
 *
 * Precondition
 * Exist at least 1 record on the grid
 *
 * Steps
 * 1. Go to backend > Sales > Manage Roles
 * 2. Tick on checkbox to select 1 Role on the grid
 * 3. Click on Mass action > Delete
 * 4. Click on [Cancel] button
 *
 * Acceptance
 * 1. Show a confirmation popup with message: "Are you sure you want to delete selected items?" and 2 buttons: Cancel, OK
 * 2. Close the confirmation popup, no record is deleted
 *
 * Class WebposManageRoleMR10Test
 * @package Magento\Webpos\Test\TestCase\Role\MassAction
 */
class WebposManageRoleMR10Test extends Injectable
{
    /**
     * Role Grid Page
     *
     * @var $_roleIndex
     */
    protected $_roleIndex;

    public function __inject(WebposRoleIndex $roleIndex)
    {
        $this->_roleIndex = $roleIndex;
    }

    public function test(WebposRole $role)
    {
        $role->persist();
        $this->_roleIndex->open();
        $this->_roleIndex->getRoleGrid()->selectItems([
            [
                'display_name' => $role->getDisplayName()
            ]
        ]);
        $this->_roleIndex->getRoleGrid()->selectAction('Delete');
        $this->_roleIndex->getModal()->waitForLoader();
        \PHPUnit_Framework_Assert::assertTrue(
            $this->_roleIndex->getModal()->isVisible(),
            'Confirmation Popup could n\'t show'
        );
        sleep(1);
        $this->_roleIndex->getModal()->getCancelButton()->click();
    }

}