<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/17/2018
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertTaxAmountNoApplyTaxToFpt extends AbstractConstraint
{
    public function processAssert($productPriceExcludeTax, $actualTaxAmount, $taxRate)
    {
        $taxAmount = $productPriceExcludeTax * $taxRate / 100;
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'Tax amount is not equals actual tax amount.'
            . "\nExpected: " . $taxAmount
            . "\nActual: " . $actualTaxAmount
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Tax amount is correct.';
    }
}