<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/4/18
 * Time: 2:22 PM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertStaffGridWithNoResult extends AbstractConstraint
{

    public function processAssert(StaffIndex $staffIndex){
        \PHPUnit_Framework_Assert::assertFalse(
            $staffIndex->getStaffsGrid()->isFirstRowVisible(),
            'Grid has no staff'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Staff Grid has least staff';
    }
}