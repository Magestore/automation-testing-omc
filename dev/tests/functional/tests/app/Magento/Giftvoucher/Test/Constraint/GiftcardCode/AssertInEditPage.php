<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeEdit;

class AssertInEditPage extends AbstractConstraint
{
    public function processAssert(GiftcodeEdit $giftcodeEdit)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $giftcodeEdit->getGiftcodeForm()->isVisible(),
            'Editing page is not showed.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Editing page is displayed.';
    }
}
