<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 4:05 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertProductPriceOnRefundPopupWithTaxCaculationBaseOnBilling extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products, $taxRate)
    {
        $productPrice = $products[0]['product']->getPrice() *(1 + $taxRate / 100);
        $actualProductPrice = $webposIndex->getOrderHistoryRefund()->getItemPrice($products[0]['product']->getName())->getText();
        $actualProductPrice = substr($actualProductPrice, 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $productPrice,
            $actualProductPrice,
            'Product price is not equals actual product price.'
            . "\nExpected: " . $productPrice
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
        return 'Product price is equals actual product price.';
    }
}