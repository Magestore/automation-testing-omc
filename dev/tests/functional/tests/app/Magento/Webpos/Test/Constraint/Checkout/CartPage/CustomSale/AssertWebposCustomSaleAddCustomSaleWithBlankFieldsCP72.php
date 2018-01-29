<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 10:38 AM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebposCustomSaleAddCustomSaleWithBlankFieldsCP72
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale
 */
class AssertWebposCustomSaleAddCustomSaleWithBlankFieldsCP72 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $name = "Custom Product";
        \PHPUnit_Framework_Assert::assertEquals(
            $name,
            $webposIndex->getCheckoutCartItems()->getCartItemName($name),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Sale. Name not Custom product'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            (float) 0.00,
            (float) $webposIndex->getCheckoutCartItems()->getValueItemPrice($name),
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