<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 4:27 PM
 */

namespace Magento\Storepickup\Test\Constraint\Specialday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;

class AssertSpecialdayMassDeleteSuccessMessage extends AbstractConstraint
{
    /**
     * Message that appears after deletion via mass actions
     */
    const SUCCESS_DELETE_MESSAGE = 'A total of %d record(s) have been deleted.';

    /**
     * Assert that message "A total of "x" record(s) were deleted."
     *
     * @param $specialdaysQtyToDelete
     * @param SpecialdayIndex $specialdayIndex
     * @return void
     */
    public function processAssert($specialdaysQtyToDelete, SpecialdayIndex $specialdayIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf(self::SUCCESS_DELETE_MESSAGE, $specialdaysQtyToDelete),
            $specialdayIndex->getMessagesBlock()->getSuccessMessage(),
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
        return 'Mass delete specialday message is displayed.';
    }
}