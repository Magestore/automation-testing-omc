<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 09:20
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

class AssertStaffMassChangeStatusSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after change status via mass actions
     */
    const SUCCESS_CHANGE_STATUS_MESSAGE = 'A total of %d record(s) were updated.';

    /**
     * Assert that message "A total of %d record(s) were updated."
     *
     * @param $staffQty
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert($staffQty, $status, StaffIndex $staffIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_CHANGE_STATUS_MESSAGE, $staffQty, strtolower($status)),
            $staffIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong ' . $status . ' message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass change status staff message is displayed.';
    }
}
{

}