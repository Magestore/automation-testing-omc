<?php
/**
 * Created by PhpStorm.
 * User: bo
 * Date: 5/8/18
 * Time: 3:00 PM
 */

namespace Magento\Webpos\Test\Constraint\Role\CheckGUI;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertCheckRoleForm extends AbstractConstraint
{
    public function processAssert(WebposRoleNew $roleNew, $title, $tabs)
    {
        $this->assertTitle($roleNew, $title);
        foreach ($tabs as $tab) {
            $this->assertTabVisible($roleNew, $tab['name']);
        }
    }

    private function assertTitle(WebposRoleNew $webposRoleNew, $title)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $title,
            $webposRoleNew->getTitleBlock()->getTitle(),
            'Page Title shows incorrect'
        );
    }

    private function assertTabVisible(WebposRoleNew $webposRoleNew, $tab)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposRoleNew->getRoleForm()->isTabVisible($tab),
            'Tab ' . $tab . '  could n\'t show'
        );
    }

    public function assertTabRoleFormField(WebposRoleNew $webposRoleNew, $tab, $fields)
    {
        $webposRoleNew->getRoleForm()->openTab($tab);
        foreach ($fields as $field) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposRoleNew->getRoleForm()->getFormFieldByName($field)->isPresent(),
                'Field ' . $field . ' could n\'t show'
            );
        }
    }

    public function assertTabRolePermission(WebposRoleNew $webposRoleNew, $fields)
    {
        foreach ($fields as $field) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposRoleNew->getRoleForm()->getPermissionByName($field)->isPresent(),
                $field . ' could n\'t show'
            );
        }
    }

    public function assertTabStaffList(WebposRoleNew $webposRoleNew, $fields){
        foreach ($fields as $field) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposRoleNew->getRoleForm()->getFieldStaffList($field)->isVisible(),
                'Field '. $field . ' could n\'t show'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Role Form Page show is correct';
    }
}