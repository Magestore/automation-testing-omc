<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 08/05/2018
 * Time: 14:41
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\GUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertFilterBlockNotVisible extends AbstractConstraint
{
    /**
     * @param StaffIndex $staffIndex
     */
    public function processAssert(StaffIndex $staffIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $staffIndex->getStaffsGrid()->getFilterBlock()->isVisible(),
            'Filter Block is visible.'
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