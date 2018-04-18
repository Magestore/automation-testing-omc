<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGiftcodeSentInGrid extends AbstractConstraint
{
    /**
     * Assert that after mass update status.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param array $items
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, array $items)
    {
        $grid = $giftcodeIndex->getGiftcodeGroupGrid();
        foreach ($items as $item) {
            \PHPUnit_Framework_Assert::assertEquals(
                'Sent via Email',
                $grid->getColumnValue($item['giftvoucher_id'], 'Send To Customer'),
                'Status does not change'
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
        return 'Gift code grid status display match target message';
    }
}
