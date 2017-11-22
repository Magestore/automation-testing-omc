<?php
namespace Magento\Giftvoucher\Test\Constraint\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexAdd;

class AssertGiftcodeExistedMessage extends AbstractConstraint
{
    const EXISTED_MESSAGE = 'This gift code has already existed in your list.';

    public function processAssert(GiftvoucherIndexAdd $giftvoucherIndexAdd)
    {
        $actualMessage = $giftvoucherIndexAdd->getMessages()->getErrorMessage();
        \PHPUnit_Framework_Assert::assertEquals(
            self::EXISTED_MESSAGE,
            $actualMessage,
            'Wrong success message is displayed.'
            . "\nExpected: " . self::EXISTED_MESSAGE
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
        return 'Existed message is displayed.';
    }
}
