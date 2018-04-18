<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGiftcodeSuccessImportMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'Imported total %d Gift Code(s)';

    /**
     * Assert that after save Synonym Group successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param int $total
     * @return void
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, $total = 3)
    {
        $successMsg = sprintf(self::SUCCESS_MESSAGE, $total);
        $actualMessage = $giftcodeIndex->getMessagesBlock()->getSuccessMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            $successMsg,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . $successMsg
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
        return 'Success import message is displayed.';
    }
}
