<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/19/2018
 * Time: 2:16 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertTaxAmountAndDiscountAmountWithApplyDiscountOnPriceIncludingTax extends AbstractConstraint
{
    public function processAssert($products, $originTaxRate, $currentTaxRate, $actualTaxAmount, $actualDiscountAmount, $discountPercent)
    {
        $subtotalIncludeTax = 0;
        foreach ($products as $item) {
            $priceIncludeOriginTax = $item['product']->getPrice();
            $subtotalIncludeTax += $priceIncludeOriginTax * $item['orderQty'] / (1 + $originTaxRate / 100);
        }
        $subtotalIncludeTax *= (1 + $currentTaxRate / 100);
        $discountAmount = round($subtotalIncludeTax * $discountPercent / 100, 2);
        \PHPUnit_Framework_Assert::assertEquals(
            $discountAmount,
            $actualDiscountAmount,
            'Discount value is not equals actual discount value.'
            . "\nExpected: " . $discountAmount
            . "\nActual: " . $actualDiscountAmount
        );
        $taxAmount = round(($subtotalIncludeTax - $discountAmount) * ($currentTaxRate / 100) / (1 + $currentTaxRate / 100), 2);
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
        return 'Tax amount and discount amount is correct.';
    }
}