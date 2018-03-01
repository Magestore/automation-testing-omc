<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 4:53 PM
 */

namespace Magento\Webpos\Test\Constraint\Role\EditRole;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;
use Magento\Webpos\Test\Fixture\WebposRole;

/**
 * Class AssertRoleInformationOnFormIsCorrect
 * @package Magento\Webpos\Test\Constraint\Role\EditRole
 */
class AssertRoleInformationOnFormIsCorrect extends AbstractConstraint
{
    /**
     * @param WebposRoleNew $webposRoleNew
     * @param WebposRole $role
     * @throws \Exception
     */
    public function processAssert(WebposRoleNew $webposRoleNew, WebposRole $role)
    {
        $fieldsData = $webposRoleNew->getRoleForm()->getTab('general')->getFieldsData();
        \PHPUnit_Framework_Assert::assertEquals(
            $role->getDisplayName(),
            $fieldsData['display_name'],
            'Display name is not correctly.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $role->getMaximumDiscountPercent(),
            $fieldsData['maximum_discount_percent'],
            'Max discount percent is not correctly.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $role->getDescription(),
            $fieldsData['description'],
            'Description is not correctly.'
        );

        $webposRoleNew->getRoleForm()->openTab('permission');
        $fieldsDataPermissionTab = $webposRoleNew->getRoleForm()->getTab('permission')->getFieldsData(['all' => 1]);
        \PHPUnit_Framework_Assert::assertEquals(
            'All',
            $fieldsDataPermissionTab['all'],
            'Roles Resources is not correctly.'
        );

        $webposRoleNew->getRoleForm()->openTab('user_section');
        $staffGridBlock = $webposRoleNew->getRoleForm()->getTab('user_section')->getUserGrid();
        $staffGridBlock->getFirstItemId();
        \PHPUnit_Framework_Assert::assertEquals(
            $role->getStaffId()[0],
            $staffGridBlock->getFirstItemId(),
            'Staff list is not correctly.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Role Information on form is correctly.';
    }
}