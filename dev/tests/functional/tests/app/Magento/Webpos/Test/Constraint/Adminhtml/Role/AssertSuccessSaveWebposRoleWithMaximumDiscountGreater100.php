<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/27/2018
 * Time: 1:43 PM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Role;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleIndex;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertSuccessSaveWebposRoleWithMaximumDiscountGreater100 extends AbstractConstraint
{
    public function processAssert(WebposRoleIndex $webposRoleIndex, WebposRoleNew $webposRoleNew, WebposRole $role)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Maximum discount percent cannot be higher than 100',
            $webposRoleIndex->getMessagesBlock()->getErrorMessage(),
            'Error message is wrong'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'Role was successfully saved',
            $webposRoleIndex->getMessagesBlock()->getSuccessMessage(),
            'Success save message is wrong'
        );
        $data = $role->getData();
        $filter = [
            'display_name' => $data['display_name'],
        ];

        \PHPUnit_Framework_Assert::assertTrue(
            $webposRoleIndex->getRoleGrid()->isRowVisible($filter, true, false),
            'Role with '
            . 'display name \'' . $filter['display_name'] . '\', '
            . 'is absent in Role grid.'
        );
        $webposRoleIndex->getRoleGrid()->searchAndOpen($filter);
        $fieldsData = $webposRoleNew->getRoleForm()->getTab('general')->getFieldsData();
        \PHPUnit_Framework_Assert::assertEquals(
            100,
            $fieldsData['maximum_discount_percent'],
            'Max discount percent is not equal 100'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Webpos Role save successfully.';
    }
}