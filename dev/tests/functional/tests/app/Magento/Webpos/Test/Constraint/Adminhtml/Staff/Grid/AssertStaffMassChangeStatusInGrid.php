<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 09:20
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertStaffMassChangeStatusInGrid extends AbstractConstraint
{
    /**
     * @param Staff[] $staffs
     * @param StaffIndex $staffIndex
     * @param string $status
     */
    public function processAssert(
        $staffs,
        StaffIndex $staffIndex,
        $status
    ) {
        $staffIndex->open();
        foreach ($staffs as $staff) {
            $filter = [
                'username' => $staff->getUsername()
            ];
            $staffIndex->getStaffsGrid()->search($filter);
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getStaffsGrid()->isRowVisible($filter, false, false),
                'Staff is absent in Staff grid'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                count($staffIndex->getStaffsGrid()->getAllIds()),
                1,
                'There is more than one staff founded'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $status,
                $staffIndex->getStaffsGrid()->getColumnOfDataGridFirstRow(8)->getText(),
                'Status of Staff not correct'
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
        return 'Staff is present in grid.';
    }
}