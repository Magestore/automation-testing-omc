<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftTemplate;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftTemplateSuccessSaveMessage extends AbstractConstraint
{
    const SUCCESS_MESSAGE = 'You saved the gift card template.';
    
    /**
     * Assert that after save Synonym Group successful message appears.
     *
     * @param GiftTemplateIndex $giftTemplateIndex
     * @return void
     */
    public function processAssert(GiftTemplateIndex $giftTemplateIndex)
    {
        $actualMessage = $giftTemplateIndex->getMessagesBlock()->getSuccessMessage();
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
