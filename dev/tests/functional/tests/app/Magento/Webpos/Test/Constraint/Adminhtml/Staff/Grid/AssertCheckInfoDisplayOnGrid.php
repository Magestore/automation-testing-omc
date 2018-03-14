<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;

use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Check that success message is displayed after widget saved
 */
class AssertCheckInfoDisplayOnGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, Staff $staff)
    {
        $staffIndex->getStaffsGrid()->search(['email' => $staff->getEmail()]);
        $id = $staffIndex->getStaffsGrid()->getAllIds()[0];

        \PHPUnit_Framework_Assert::assertEquals(
            $staff->getUsername(),
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Username'),
            'UserName is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $staff->getEmail(),
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Email'),
            'Email is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $staff->getDisplayName(),
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Display Name'),
            'Display Name is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $staff->getLocationId(),
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Location'),
            'Location is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $staff->getRoleId(),
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Role'),
            'Role is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $staff->getStatus(),
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Status'),
            'Status is incorrect'
        );

        $staffIndex->getStaffsGrid()->resetFilter();
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Info staff is incorrec on grid';
    }
}
