<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 22/05/2018
 * Time: 15:46
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

/**
 * Class AdminSessionManagementLR21Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckAssignmentPermissionForPOSStaffs
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

    public function test(WebposRole $webposRole)
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