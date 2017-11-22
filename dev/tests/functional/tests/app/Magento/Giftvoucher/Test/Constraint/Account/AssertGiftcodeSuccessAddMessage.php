<?php
namespace Magento\Giftvoucher\Test\Constraint\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexIndex;

class AssertGiftcodeSuccessAddMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'The gift code has been added to your list successfully.';
    
    public function processAssert(GiftvoucherIndexIndex $giftvoucherIndexIndex)
    {
        $actualMessage = $giftvoucherIndexIndex->getMessages()->getSuccessMessage();
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
