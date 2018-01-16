<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/15/2018
 * Time: 3:06 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $taxRate float
     * @param $product CatalogProductSimple
     */
    public function processAssert(WebposIndex $webposIndex, $taxRate, $product)
    {
        $priceIncludeTax = $product->getPrice();
        $priceExcludeTax = round($priceIncludeTax / (1 + $taxRate / 100), 2);
        $actualPriceExcludeTax = $webposIndex->getCheckoutCartItems()->getCartItemPrice($product->getName())->getText();
        $actualPriceExcludeTax = substr($actualPriceExcludeTax, 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $priceExcludeTax,
            $actualPriceExcludeTax,
            'Product price exclude tax is not equals actual product price exclude tax.'
            . "\nExpected: " . $priceExcludeTax
            . "\nActual: " . $actualPriceExcludeTax
        );
        $taxAmount = round($priceExcludeTax * $taxRate / 100, 2);
        $actualTaxAmount = $webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText();
        $actualTaxAmount = substr($actualTaxAmount, 1);
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
        return 'Product price and tax amount are equal actual value';
    }
}