<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftcodeSuccessDeleteMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'Gift Code was successfully deleted';
    
    const MASS_SUCCESS_MESSAGE = 'A total of %s record(s) have been deleted.';
    
    /**
     * Assert that after delete gift code successful message appears.
     *
     * @param array $messages
     * @param array $giftcodes
     * @return void
     */
    public function processAssert($messages, $giftcodes)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            self::SUCCESS_MESSAGE,
            $messages['delete'],
            'Wrong success message is displayed.'
            . "\nExpected: " . self::SUCCESS_MESSAGE
            . "\nActual: " . $messages['delete']
        );
        
        $successMsg = sprintf(self::MASS_SUCCESS_MESSAGE, count($giftcodes) - 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $successMsg,
            $messages['mass_delete'],
            'Wrong success message is displayed.'
            . "\nExpected: " . $successMsg
            . "\nActual: " . $messages['mass_delete']
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
