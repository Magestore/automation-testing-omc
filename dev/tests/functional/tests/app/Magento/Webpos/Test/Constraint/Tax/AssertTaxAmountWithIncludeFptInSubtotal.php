<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/18/2018
 * Time: 10:39 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertTaxAmountWithIncludeFptInSubtotal extends AbstractConstraint
{
    public function processAssert($productPriceExcludeTax, $taxRate, $fptTax, $actualTaxAmount, $actualSubtotal, $actualGrandtotal)
    {
        $taxAmount = $productPriceExcludeTax * $taxRate / 100;
        $subtotal = $productPriceExcludeTax + $fptTax;
        $grandtotal = $productPriceExcludeTax + $fptTax + $taxAmount;
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'Tax amount is not equals actual tax amount.'
            . "\nExpected: " . $taxAmount
            . "\nActual: " . $actualTaxAmount
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $subtotal,
            $actualSubtotal,
            'Subtotal is not equals actual subtotal.'
            . "\nExpected: " . $subtotal
            . "\nActual: " . $actualSubtotal
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $grandtotal,
            $actualGrandtotal,
            'Grandtotal is not equals actual grandtotal.'
            . "\nExpected: " . $grandtotal
            . "\nActual: " . $actualGrandtotal
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        // TODO: Implement toString() method.
    }
}