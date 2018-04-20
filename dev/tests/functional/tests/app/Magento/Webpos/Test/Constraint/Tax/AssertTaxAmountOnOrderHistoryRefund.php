<?php
/**
 * Created by PhpStorm.
 * User: Pink
 * Date: 04/20/2018
 * Time: 13:53 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTaxAmountOnOrderHistoryRefund extends AbstractConstraint
{
    public function processAssert($taxRate, $products, WebposIndex $webposIndex)
    {
        foreach ($products as $product)
        {
            $productPrice = $product['product']->getPrice() *(1 + $taxRate / 100);
            $productPriceOnPage = $webposIndex->getOrderHistoryRefund()->getItemPrice($product['product']->getName());
            $productPriceOnPage = substr($productPriceOnPage, 1);
            \PHPUnit_Framework_Assert::assertEquals(
                $productPrice,
                $productPriceOnPage,
                'Product price is not equals actual product price.'
                . "\nExpected: " . $productPrice
                . "\nActual: " . $productPriceOnPage
            );
        }

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product price is equals actual product price.';
    }
}