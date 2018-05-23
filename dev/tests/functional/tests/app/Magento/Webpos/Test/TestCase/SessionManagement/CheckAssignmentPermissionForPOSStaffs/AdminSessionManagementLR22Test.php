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