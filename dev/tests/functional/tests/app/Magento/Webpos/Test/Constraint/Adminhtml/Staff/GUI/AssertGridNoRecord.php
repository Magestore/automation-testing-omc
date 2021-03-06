<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 08/05/2018
 * Time: 15:17
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\GUI;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertGridNoRecord extends AbstractConstraint
{
    /**
     * @param StaffIndex $staffIndex
     */
    public function processAssert(StaffIndex $staffIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $staffIndex->getStaffsGrid()->getDataGridFirstRow()->isVisible(),
            'Filter Block error'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Staff Grid- Filter Block is correctly.';
    }
}