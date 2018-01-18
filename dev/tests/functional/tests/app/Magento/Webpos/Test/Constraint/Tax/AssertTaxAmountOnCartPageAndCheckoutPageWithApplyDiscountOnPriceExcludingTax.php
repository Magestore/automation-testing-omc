<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/17/2018
 * Time: 8:14 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnCartPageAndCheckoutPageWithApplyDiscountOnPriceExcludingTax extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products, $taxRate, $discountAmount)
    {
        $productPriceExcludeTax = $products[0]['product']->getPrice();
        $discountValue = round($productPriceExcludeTax * $discountAmount / 100, 2);
        $actualDiscountValue = substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Discount')->getText(), 2);
        \PHPUnit_Framework_Assert::assertEquals(
            $discountValue,
            $actualDiscountValue,
            'Discount value is not equals actual discount value.'
            . "\nExpected: " . $discountValue
            . "\nActual: " . $actualDiscountValue
        );
        $subtotal = substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(), 1);
        $taxAmount = round(($subtotal - $discountValue) * $taxRate / 100, 2);
        $actualTaxAmount = substr($webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'Discount value is not equals actual discount value.'
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