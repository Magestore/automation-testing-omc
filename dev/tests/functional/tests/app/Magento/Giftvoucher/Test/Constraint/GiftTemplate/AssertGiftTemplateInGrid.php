<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftTemplate;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftTemplateIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftTemplateInGrid extends AbstractConstraint
{
    /**
     * Assert that after save giftTemplate successful message appears.
     *
     * @param GiftTemplateIndex $giftTemplateIndex
     * @param array|null $giftTemplate
     * @return void
     */
    public function processAssert(GiftTemplateIndex $giftTemplateIndex, $giftTemplate)
    {
        $giftTemplateGrid = $giftTemplateIndex->getGiftTemplateGroupGrid();
        // Must show grid
        \PHPUnit_Framework_Assert::assertNotFalse(
            $giftTemplateGrid->isVisible(),
            'Gift card template grid is not visible.'
        );
        // Gift code index in grid
        if (null !== $giftTemplate) {
            $filter = [
                'template_name' => $giftTemplate['template_name'],
            ];
            \PHPUnit_Framework_Assert::assertTrue(
                $giftTemplateGrid->isRowVisible($filter, true, false),
                'Gift card template \'' . $giftTemplate['template_name'] . '\' is not present in gift code grid.'
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
        return 'Gift card template Grid display match columns and message';
    }
}
