<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/18/2018
 * Time: 10:39 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertTaxAmountWithIncludeFptInSubtotal
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountWithIncludeFptInSubtotal extends AbstractConstraint
{
    public function processAssert(
        $productPriceExcludeTax,
        $taxRate,
        $fptTax,
        $actualTaxAmount,
        $actualSubtotal,
        $actualGrandtotal,
        $shippingHandling = 0
    )
    {
        sleep(2);
        $taxAmount = $productPriceExcludeTax * $taxRate / 100;
        $subtotal = $productPriceExcludeTax;
        $grandtotal = $productPriceExcludeTax + $fptTax + $taxAmount + $shippingHandling;
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'Tax amount is not equals actual tax amount.'
            . "\nExpected: " . $taxAmount
            . "\nActual: " . $actualTaxAmount
        );
        \PHPUnit_Framework_Assert::assertEquals(
            (float)($subtotal) + (float)($fptTax),
            (float)$actualSubtotal,
            'Subtotal is not equals actual subtotal.'
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