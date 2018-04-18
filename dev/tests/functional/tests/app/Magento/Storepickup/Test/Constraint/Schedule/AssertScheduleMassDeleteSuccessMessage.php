<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:18 PM
 */

namespace Magento\Storepickup\Test\Constraint\Schedule;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\ScheduleIndex;

class AssertScheduleMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) have been deleted.';

    /**
     * Assert that message "A total of "x" record(s) were deleted."
     *
     * @param $schedulesQtyToDelete
     * @param ScheduleIndex $scheduleIndex
     * @return void
     */
    public function processAssert($schedulesQtyToDelete, ScheduleIndex $scheduleIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, $schedulesQtyToDelete),
            $scheduleIndex->getMessagesBlock()->getSuccessMessage(),
            'Wrong delete message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass delete schedule message is displayed.';
    }
}