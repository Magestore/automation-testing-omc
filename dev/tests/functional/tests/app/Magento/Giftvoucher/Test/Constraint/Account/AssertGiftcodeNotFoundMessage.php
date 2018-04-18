<?php
namespace Magento\Giftvoucher\Test\Constraint\Account;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexIndex;

class AssertGiftcodeNotFoundMessage extends AbstractConstraint
{
    const NOT_FOUND_MESSAGE = 'There are no gift codes matching this selection.';
    
    public function processAssert(GiftvoucherIndexIndex $giftvoucherIndexIndex, $code)
    {
        $grid = $giftvoucherIndexIndex->getAccountGiftcodesBlock()->search($code);
        $actualMessage = $grid->find('tbody td')->getText();
        
        \PHPUnit_Framework_Assert::assertEquals(
            self::NOT_FOUND_MESSAGE,
            $actualMessage,
            'Wrong message is displayed.'
            . "\nExpected: " . self::NOT_FOUND_MESSAGE
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
        return 'Gift code is not in grid.';
    }
}
