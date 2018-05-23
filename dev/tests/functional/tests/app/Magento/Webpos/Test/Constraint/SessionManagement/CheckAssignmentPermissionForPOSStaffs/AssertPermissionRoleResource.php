<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 22/05/2018
 * Time: 16:17
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement\CheckAssignmentPermissionForPOSStaffs;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertPermissionRoleResource extends AbstractConstraint
{
    /**
     * @param WebposRoleNew $webposRoleNew
     * WebposRoleNew $webposRoleNew
     */
    public function processAssert(WebposRoleNew $webposRoleNew, $roleResources)
    {
        foreach ($roleResources as $roleResource)
        {
            \PHPUnit_Framework_Assert::assertContains(
                "jstree-checked",
                $webposRoleNew->getRoleForm()->getRoleResourceElement($roleResource)->getAttribute('class'),
                $roleResource . ' not checked'
            );
        }
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