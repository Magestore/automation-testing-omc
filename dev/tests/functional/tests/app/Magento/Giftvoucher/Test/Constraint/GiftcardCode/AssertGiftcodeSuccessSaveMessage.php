<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftcodeSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'Gift Code was successfully saved';
    
    /**
     * Assert that after save Synonym Group successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @return void
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex)
    {
        $actualMessage = $giftcodeIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . self::SUCCESS_MESSAGE
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
