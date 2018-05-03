<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/3/18
 * Time: 8:24 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
/**
 * Class CheckPositionOfLockRegisterPermissionForPOSStaffsLR20Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 * Precondition and setup steps
 *   Logged in backend
 *   From menu on the left side, select Sales menu , under Web POS > select Manage Role
 * Steps
 *   1. Add a new role or edit existed role
 *   2. Open Permission tab
 *   3. Observe role resources is displayed on
 * Acceptance Criteria
 *   2. Show role and sub-roles (sources tree type)
 *      Parent Role: Lock Register
 *      Sub-role:
 *      Lock and Unlock register
 *      Edit security PIN under Manage Inventory role.
 */
class CheckPositionOfLockRegisterPermissionForPOSStaffsLR20Test extends Injectable
{
    const SUCCESS_MESSAGE = 'Role was successfully saved';

    /**
     * @var WebposRoleIndex
     */
    protected $webposRoleIndex;

    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    public function __inject(
        WebposRoleIndex $webposRoleIndex,
        WebposRoleNew $webposRoleNew
    )
    {
        $this->webposRoleIndex = $webposRoleIndex;
        $this->webposRoleNew = $webposRoleNew;
    }

    public function test(WebposRole $webposRole)
    {
        $this->webposRoleIndex->open();
        $this->webposRoleIndex->getPageActionsBlock()->addNew();

        $this->webposRoleNew->getRoleForm()->openTab('permission');
    }
}