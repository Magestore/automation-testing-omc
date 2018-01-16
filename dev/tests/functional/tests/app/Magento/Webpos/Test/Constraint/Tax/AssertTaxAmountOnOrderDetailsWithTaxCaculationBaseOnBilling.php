<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 2:56 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnOrderDetailsWithTaxCaculationBaseOnBilling extends AbstractConstraint
{

    public function processAssert(WebposIndex $webposIndex, $products, $taxRate)
    {
        $subtotal = substr($webposIndex->getOrderHistoryOrderViewFooter()->getSubtotal(), 1);
        $taxAmount = $subtotal * $taxRate / 100;
        $actualTaxAmount = substr($webposIndex->getOrderHistoryOrderViewFooter()->getTax(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $taxAmount,
            $actualTaxAmount,
            'Tax amount is not equals actual tax amount.'
            . "\nExpected: " . $taxAmount
            . "\nActual: " . $actualTaxAmount
        );
        $productSubtotal = substr($webposIndex->getOrderHistoryOrderViewContent()->getSubTotalOfProduct($products[0]['product']->getName()), 1);
        $productTaxAmount = $productSubtotal * $taxRate / 100;
        $actualProductTaxAmount = substr($webposIndex->getOrderHistoryOrderViewContent()->getTaxAmountOfProduct($products[0]['product']->getName()), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $productTaxAmount,
            $actualProductTaxAmount,
            'Product tax amount is not equals actual product tax amount.'
            . "\nExpected: " . $productTaxAmount
            . "\nActual: " . $actualProductTaxAmount
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Tax amount is equals actual tax amount.';
    }
}