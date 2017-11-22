<?php
namespace Magento\Giftvoucher\Test\Constraint\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexAdd;

class AssertGiftcodeNotAvailableMessage extends AbstractConstraint
{
    const INVALID_REGEXP = '/Gift code "(.*)" is not avaliable/';

    public function processAssert(GiftvoucherIndexAdd $giftvoucherIndexAdd)
    {
        $actualMessage = $giftvoucherIndexAdd->getMessages()->getErrorMessage();
        \PHPUnit_Framework_Assert::assertRegExp(
            self::INVALID_REGEXP,
            $actualMessage,
            'Wrong invalid message is displayed.'
            . "\nExpected: " . self::INVALID_REGEXP
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
        return 'Invalid message is displayed.';
    }
}
