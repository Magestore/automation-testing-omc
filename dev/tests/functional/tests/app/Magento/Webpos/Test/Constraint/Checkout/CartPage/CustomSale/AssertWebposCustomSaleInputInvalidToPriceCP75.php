<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 2:34 PM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebposCustomSaleInputInvalidToPriceCP75
 * @package Magento\Webpos\Test\Constraint\Cart\CartPage\CustomSale
 */
class AssertWebposCustomSaleInputInvalidToPriceCP75 extends  AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $productName,$price)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $productName,
            $webposIndex->getCheckoutCartItems()->getCartItemName($productName),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Name not Custom product'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            (float) 0.00,
            (float) $webposIndex->getCheckoutCartItems()->getValueItemPrice($productName),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Input Product Description is not show.'
        );
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