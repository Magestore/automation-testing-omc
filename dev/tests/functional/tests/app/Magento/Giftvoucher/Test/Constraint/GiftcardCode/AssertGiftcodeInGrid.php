<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftcodeInGrid extends AbstractConstraint
{
    /**
     * Assert that after save giftcode successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param array|null $giftcode
     * @return void
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, $giftcode)
    {
        $giftcodeGrid = $giftcodeIndex->getGiftcodeGroupGrid();
        // Must show grid
        \PHPUnit_Framework_Assert::assertNotFalse(
            $giftcodeGrid->isVisible(),
            'Gift code grid is not visible.'
        );
        // Gift code index in grid
        if (null !== $giftcode) {
            $filter = [
                'gift_code' => $giftcode['gift_code'],
            ];
            \PHPUnit_Framework_Assert::assertTrue(
                $giftcodeGrid->isRowVisible($filter, true, false),
                'Gift code \'' . $giftcode['gift_code'] . '\' is not present in gift code grid.'
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
        return 'Gift Codes Grid display match columns and message';
    }
}
