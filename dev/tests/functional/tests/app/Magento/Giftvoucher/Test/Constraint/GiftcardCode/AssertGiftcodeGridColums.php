<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardCode;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftcodeIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftcodeGridColums extends AbstractConstraint
{
    /**
     * Assert that after save Synonym Group successful message appears.
     *
     * @param GiftcodeIndex $giftcodeIndex
     * @param array $result
     * @return void
     */
    public function processAssert(GiftcodeIndex $giftcodeIndex, $result)
    {
        $giftcodeGrid = $giftcodeIndex->getGiftcodeGroupGrid();
        // Must show grid
        \PHPUnit_Framework_Assert::assertNotFalse(
            $giftcodeGrid->isVisible(),
            'Gift code grid is not visible.'
        );
        
        // MGC033
        foreach ($result as $perPage => $rows) {
            \PHPUnit_Framework_Assert::assertLessThanOrEqual(
                $perPage,
                $rows,
                'Grid show more items than config, config: ' . $perPage . ' rows: ' . $rows
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
