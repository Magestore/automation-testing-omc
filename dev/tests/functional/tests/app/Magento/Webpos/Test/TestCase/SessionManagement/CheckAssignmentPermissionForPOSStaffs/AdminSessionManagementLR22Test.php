<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 22/05/2018
 * Time: 15:46
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 * Class AdminSessionManagementLR22Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 *
 * Precondition:
 * - Logged in backend
 * - From menu on the left side, select Sales menu , under Web POS > select Manage Role
 *
 * Steps:
 * 1. Add a new role or edit existed role
 * 2. Open Permission tab
 * 3. In the Resource Access field, select option: custom
 * 4. Tick on Lock and Unlock register checkbox or Edit security PIN checkbox
 *
 * Acceptance:
 * 4. The Lock Register checkbox would be automatically checked
 *
 */
class AdminSessionManagementLR22Test extends Injectable
{
    /**
     * @var WebposRoleNew
     */
    protected $webposRoleNew;

    public function __inject(
        WebposRoleNew $webposRoleNew
    )
    {
        $this->webposRoleNew = $webposRoleNew;
    }

    public function test()
    {
        $this->webposRoleNew->open();
        $this->webposRoleNew->getRoleForm()->openTab('permission');

        $roleResourcesClick = [
            'Magestore_Webpos::edit_pin'
        ];

        $roleResourcesCheck = [
            'Magestore_Webpos::lock_register'
        ];
        $this->webposRoleNew->getRoleForm()->getRoleResources($roleResourcesClick[0]);
        return [
            'roleResources' => $roleResourcesCheck
        ];
    }
}