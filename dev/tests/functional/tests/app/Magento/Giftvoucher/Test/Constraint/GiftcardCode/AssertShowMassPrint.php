<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeMassPrint;

class AssertShowMassPrint extends AbstractConstraint
{
    public function processAssert(GiftcodeMassPrint $giftcodeMassPrint, $count = 1)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $count,
            $giftcodeMassPrint->getPrintBlock()->getCountGiftcodes(),
            'Print popup is not showed.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Mass print is displayed.';
    }
}
