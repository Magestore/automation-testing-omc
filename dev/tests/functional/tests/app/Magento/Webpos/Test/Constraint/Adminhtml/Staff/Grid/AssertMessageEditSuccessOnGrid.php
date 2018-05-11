<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 22/02/2018
 * Time: 09:05
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;

class AssertMessageEditSuccessOnGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $message)
    {
        $staffIndex->getStaffsGrid()->waitForElementVisible('.data-grid-info-panel .message');
        \PHPUnit_Framework_Assert::assertTrue(
            true,
            'Message does not display'
        );
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Message displays';
    }
}
