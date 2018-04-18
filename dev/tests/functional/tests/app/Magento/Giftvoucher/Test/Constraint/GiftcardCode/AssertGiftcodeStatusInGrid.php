<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGiftcodeStatusInGrid extends AbstractConstraint
{
    /**
     * Assert that after mass update status.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param array $action
     * @param array $items
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, array $action, array $items)
    {
        $grid = $giftcodeIndex->getGiftcodeGroupGrid();
        foreach ($items as $item) {
            \PHPUnit_Framework_Assert::assertEquals(
                $action['Change Status'],
                $grid->getColumnValue($item['giftvoucher_id'], 'Status'),
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
