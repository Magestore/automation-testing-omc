<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/3/18
 * Time: 8:48 AM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement\CheckAssignmentPermissionForPOSStaffs;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
/**
 * Class AssertCheckPositionOfLockRegisterPermissionForPOSStaffsLR20
 * @package Magento\Webpos\Test\Constraint\SessionManagement\CheckAssignmentPermissionForPOSStaffs
 */
class AssertCheckPositionOfLockRegisterPermissionForPOSStaffsLR20 extends AbstractConstraint
{
    /**
     * @param WebposRoleNew $webposRoleNew
     * WebposRoleNew $webposRoleNew
     */
    public function processAssert(WebposRoleNew $webposRoleNew)
    {
        $arrs1 = 'Magestore_Webpos::lock_register';
        $arrs2 = [
            'Magestore_Webpos::lock_unlock_register',
            'Magestore_Webpos::edit_pin'
        ];
        sleep(1);
        $webposRoleNew->getRoleForm()->assertSubRoleResources($arrs1, $arrs2);
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Check when user assigned permission to lock register successfully.';
    }
}