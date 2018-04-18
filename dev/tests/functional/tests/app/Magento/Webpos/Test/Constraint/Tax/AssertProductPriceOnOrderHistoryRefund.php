<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/17/2018
 * Time: 8:50 AM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductPriceOnOrderHistoryRefund extends AbstractConstraint
{
    public function processAssert($taxRate, $products, WebposIndex $webposIndex)
    {
        $productPrice = $products[0]['product']->getPrice() *(1 + $taxRate / 100);
        $productPriceOnPage = $webposIndex->getOrderHistoryRefund()->getItemPrice($products[0]['product']->getName());
        $productPriceOnPage = substr($productPriceOnPage, 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $productPrice,
            $productPriceOnPage,
            'Product price is not equals actual product price.'
            . "\nExpected: " . $productPrice
            . "\nActual: " . $productPriceOnPage
        );
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