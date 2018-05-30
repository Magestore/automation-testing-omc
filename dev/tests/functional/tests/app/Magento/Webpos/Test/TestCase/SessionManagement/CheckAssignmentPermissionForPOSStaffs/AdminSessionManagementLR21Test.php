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
 * Class AdminSessionManagementLR21Test
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
 * 4. Tick on Lock Register checkbox
 *
 * Acceptance:
 * 4. The Lock and Unlock register checkbox and Edit security PIN checkbox would be automatically checked
 *
 */
class AdminSessionManagementLR21Test extends Injectable
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

        $roleResources = [
            'Magestore_Webpos::lock_register',
            'Magestore_Webpos::lock_unlock_register',
            'Magestore_Webpos::edit_pin'
        ];
        $this->webposRoleNew->getRoleForm()->getRoleResources($roleResources[0]);
        return [
            'roleResources' => $roleResources
        ];
    }
}