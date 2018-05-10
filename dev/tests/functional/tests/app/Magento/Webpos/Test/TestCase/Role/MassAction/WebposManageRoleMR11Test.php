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
 * Class WebposManageRoleMR11Test
 * @package Magento\Webpos\Test\TestCase\Role\MassAction
 */
class WebposManageRoleMR11Test extends Injectable
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
        $filters = [
            [
                'display_name' => $role->getDisplayName()
            ]
        ];
        $this->_roleIndex->getRoleGrid()->massAction($filters, 'Delete', true );
        sleep(1);
        return [
            'webposRole' => $role
        ];
    }

}