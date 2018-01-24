<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/23/2018
 * Time: 8:37 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertProductPriceOnRefundPopupWithApplyDiscountOnPriceIncludingTax extends AbstractConstraint
{
    public function processAssert($products, $originTaxRate, $currentTaxRate, $actualProductPrice)
    {
        $priceExcludeTax = $products[0]['product']->getPrice() / (1 + $originTaxRate / 100);
        $priceIncludeTax = round($priceExcludeTax * (1 + $currentTaxRate / 100),2);
        \PHPUnit_Framework_Assert::assertEquals(
            $priceIncludeTax,
            $actualProductPrice,
            'Product price is not equals actual product price.'
            . "\nExpected: " . $priceIncludeTax
            . "\nActual: " . $actualProductPrice
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product price is correct.';
    }
}