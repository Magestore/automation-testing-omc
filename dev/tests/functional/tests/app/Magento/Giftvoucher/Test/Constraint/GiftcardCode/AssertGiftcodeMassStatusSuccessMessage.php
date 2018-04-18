<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGiftcodeMassStatusSuccessMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'A total of %d record(s) have been changed status.';

    /**
     * Assert that after mass action successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param number $count
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, $count = 1)
    {
        $expectedMessage = sprintf(self::SUCCESS_MESSAGE, $count);
        $actualMessage = $giftcodeIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            $expectedMessage,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . $expectedMessage
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
        return 'Success message is displayed.';
    }
}
