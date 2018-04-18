<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftcardPattern;

use Magento\Giftvoucher\Test\Page\Adminhtml\PatternIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertPatternInGrid extends AbstractConstraint
{
    /**
     * Assert that after save gift code pattern successful message appears.
     *
     * @param PatternIndex $patternIndex
     * @param array|null $pattern
     * @return void
     */
    public function processAssert(PatternIndex $patternIndex, $pattern)
    {
        $patternGrid = $patternIndex->getPatternGroupGrid();
        // Must show grid
        \PHPUnit_Framework_Assert::assertNotFalse(
            $patternGrid->isVisible(),
            'Gift code grid is not visible.'
        );
        
        // Gift code index in grid
        if (null !== $pattern) {
            $filter = [
                'template_name' => $pattern['template_name'],
            ];
            \PHPUnit_Framework_Assert::assertTrue(
                $patternGrid->isRowVisible($filter, true, false),
                'Gift code pattern \'' . $pattern['template_name'] . '\' is not present in grid.'
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
        return 'Gift Code Patterns Grid display match columns and message';
    }
}
