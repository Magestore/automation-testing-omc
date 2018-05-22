<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/16/18
 * Time: 3:40 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\AddPos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;

class AssertStaffWithPosUnSelected extends AbstractConstraint
{

    public function processAssert(StaffIndex $staffIndex, StaffNews $staffNews, Staff $staff, Pos $pos)
    {
        $staffIndex->open();
        $staffIndex->getStaffsGrid()->searchAndOpen([
            'username' => $staff->getUsername()
        ]);
        $posArray = $staffNews->getStaffsForm()->getFieldValueById('page_pos_ids', 'multiselect');
        \PHPUnit_Framework_Assert::assertFalse(
            array_search($pos->getPosName(), $posArray),
            'Staff is still assigned pos ' . $pos->getPosName()
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Staff didn\'t assign that pos';
    }
}