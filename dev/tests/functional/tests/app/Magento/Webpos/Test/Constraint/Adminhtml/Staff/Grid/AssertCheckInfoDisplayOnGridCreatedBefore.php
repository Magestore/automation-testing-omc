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

/**
 * Check that success message is displayed after widget saved
 */
class AssertCheckInfoDisplayOnGridCreatedBefore extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $dataStaff)
    {
        $staffIndex->getStaffsGrid()->search(['email' => $dataStaff['email']]);
        $id = $staffIndex->getStaffsGrid()->getAllIds()[0];
        \PHPUnit_Framework_Assert::assertEquals(
            $dataStaff['username'],
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Username'),
            'UserName is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $dataStaff['email'],
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Email'),
            'Email is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $dataStaff['display_name'],
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Display Name'),
            'Display Name is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $dataStaff['location_id'],
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Location'),
            'Location is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $dataStaff['role_id'],
            $staffIndex->getStaffsGrid()->getColumnValue($id, 'Role'),
            'Role is incorrect'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $dataStaff['status'],
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
