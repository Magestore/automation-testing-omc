<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeEdit;

/**
 *
 */
class AssertGiftcodeSuccessEmailMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'Gift Code was successfully saved';
    const EMAIL_MESSAGE = 'and %d email(s) were sent.';
    
    public function processAssert(GiftcodeEdit $giftcodeEdit, $numberEmail = 1)
    {
        $actualMessages = $giftcodeEdit->getMessagesBlock()->getSuccessMessages();
        \PHPUnit_Framework_Assert::assertEquals(
            [
                self::SUCCESS_MESSAGE,
                sprintf(self::EMAIL_MESSAGE, $numberEmail),
            ],
            $actualMessages,
            'Wrong success message is displayed.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Success email message is displayed.';
    }
}
