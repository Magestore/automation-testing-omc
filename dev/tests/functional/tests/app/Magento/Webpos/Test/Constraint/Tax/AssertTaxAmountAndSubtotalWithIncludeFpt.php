<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/19/2018
 * Time: 8:21 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertTaxAmountAndSubtotalWithIncludeFpt
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertTaxAmountAndSubtotalWithIncludeFpt extends AbstractConstraint
{
    /**
     * @param $productPriceExcludeTax
     * @param $taxRate
     * @param $actualTaxAmount
     * @param $actualSubtotal
     */
    public function processAssert($productPriceExcludeTax, $taxRate, $actualTaxAmount, $actualSubtotal)
    {
        $taxAmount = $productPriceExcludeTax * $taxRate / 100;
        $subtotal = $productPriceExcludeTax;

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
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "The Tax and The Subtotal at the web POS was correctly.";
    }
}