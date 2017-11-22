<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftTemplate;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGridColums extends AbstractConstraint
{
    /**
     * Assert that after save Synonym Group successful message appears.
     *
     * @param GiftTemplateIndex $giftTemplateIndex
     * @return void
     */
    public function processAssert(GiftTemplateIndex $giftTemplateIndex)
    {
        $grid = $giftTemplateIndex->getGiftTemplateGroupGrid();
        // Must show grid
        \PHPUnit_Framework_Assert::assertNotFalse(
            $grid->isVisible(),
            'Gift Card Template grid is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift Card Template Grid display match columns and message';
    }
}
