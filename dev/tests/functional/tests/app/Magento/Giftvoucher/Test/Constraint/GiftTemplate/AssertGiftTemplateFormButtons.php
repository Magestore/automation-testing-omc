<?php

namespace Magento\Giftvoucher\Test\Constraint\GiftTemplate;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 *
 */
class AssertGiftTemplateFormButtons extends AbstractConstraint
{
    /**
     * Assert that after run form buttons test.
     *
     * @param array $testResult
     * @return void
     */
    public function processAssert(array $testResult)
    {
        // MGC002
        \PHPUnit_Framework_Assert::assertNotFalse(
            $testResult['newGiftTemplatePageShowed'],
            'new gift card template page is not showed.'
        );
        
        // MGC003
        /*
        \PHPUnit_Framework_Assert::assertNotEquals(
            $testResult['resetForm']['before'],
            $testResult['resetForm']['filling'],
            'form is not filled'
        );
         */
        
        \PHPUnit_Framework_Assert::assertEquals(
            $testResult['resetForm']['before'],
            $testResult['resetForm']['after'],
            'reset form does not work correctly'
        );
        
        // MGC004
        \PHPUnit_Framework_Assert::assertNotFalse(
            $testResult['giftTemplateGridShowed'],
            'does not go back to gift card template grid'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Gift Card Template Form buttons work accurately';
    }
}
