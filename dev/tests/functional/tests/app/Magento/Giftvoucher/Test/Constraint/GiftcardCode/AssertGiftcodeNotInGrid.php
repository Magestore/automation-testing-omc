<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftcodeNotInGrid extends AbstractConstraint
{
    /**
     * Assert that after delete giftcode successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param array $giftcodes
     * @return void
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, $giftcodes)
    {
        $giftcodeGrid = $giftcodeIndex->getGiftcodeGroupGrid();
        foreach ($giftcodes as $giftcode) {
            $filter = [
                'gift_code' => $giftcode->getGiftCode(),
            ];
            \PHPUnit_Framework_Assert::assertFalse(
                $giftcodeGrid->isRowVisible($filter),
                'Deleted gift code \'' . $giftcode->getGiftCode() . '\' is still present in gift code grid.'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift Codes Grid does not display deleted Gift Code';
    }
}
