<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGiftcodeMassEmailSuccessMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'Total of %d Gift Code with %d email(s) were successfully sent.';

    /**
     * Assert that after mass action successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param number $count
     * @param number $email
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, $count = 1, $email = 1)
    {
        $expectedMessage = sprintf(self::SUCCESS_MESSAGE, $count, $count * $email);
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
