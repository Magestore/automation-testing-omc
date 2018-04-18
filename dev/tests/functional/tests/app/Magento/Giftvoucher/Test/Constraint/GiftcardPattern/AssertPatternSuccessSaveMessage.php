<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardPattern;

use Magento\Giftvoucher\Test\Page\Adminhtml\PatternIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertPatternSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'The pattern has been saved successfully.';
    
    /**
     * Assert that after save pattern successful message appears.
     *
     * @param PatternIndex $patternIndex
     * @return void
     */
    public function processAssert(PatternIndex $patternIndex)
    {
        $actualMessage = $patternIndex->getMessagesBlock()->getSuccessMessage();
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
