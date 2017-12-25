<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/18/2017
 * Time: 2:15 PM
 */

namespace Magento\Storepickup\Test\Constraint\Holiday;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\HolidayIndex;

class AssertHolidaySuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_SAVE_MESSAGE = 'The Holiday has been saved.';

    public function processAssert(HolidayIndex $holidayIndex)
    {
        $actualMessage = $holidayIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_SAVE_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . self::SUCCESS_SAVE_MESSAGE
            . "\nActual: " . $actualMessage
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Holiday success create message is present.';
    }
}