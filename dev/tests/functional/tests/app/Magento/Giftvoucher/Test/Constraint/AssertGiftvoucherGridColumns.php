<?php

namespace Magento\Giftvoucher\Test\Constraint;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftVoucherProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftvoucherGridColumns extends AbstractConstraint
{
    const GRID_CLASS = 'admin__data-grid-outer-wrap';

    /**
     * Assert that after save Synonym Group successful message appears.
     *
     * @param GiftVoucherProductIndex $giftVoucherProductIndex
     * @return void
     */
    public function processAssert(GiftVoucherProductIndex $giftVoucherProductIndex)
    {
        $giftvoucherGrid = $giftVoucherProductIndex->getProductGrid();
        // Must show grid
        \PHPUnit_Framework_Assert::assertNotFalse(
            $giftvoucherGrid->isVisible(),
            'Gift code grid is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift Voucher Product Grid display match columns and message';
    }
}
