<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 2:01 PM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertWebposCustomSaleInputPriceByMouseCP73 extends  AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $productName, $productDescription)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $productName,
            $webposIndex->getCheckoutCartItems()->getCartItemName($productName),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Name not Custom product'
        );
//        \PHPUnit_Framework_Assert::assertEquals(
//            $productDescription,
//            $webposIndex->getCheckoutCartItems()->getCartItemName($productDescription),
//            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Name not Custom product'
//        );
        \PHPUnit_Framework_Assert::assertEquals(
            (float) 50.00,
            (float) $webposIndex->getCheckoutCartItems()->getValueItemPrice($productName),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input Product Description is not show.'
        );
//        \PHPUnit_Framework_Assert::assertEquals(
//            (integer) 1,
//            (integer) $webposIndex->getCheckoutCartItems()->getCartItemQty($name)->getText(),
//            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input Product price is not show.'
//        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "TaxClass page is default";
    }
}