<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/10/2018
 * Time: 2:45 PM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\DiscountProduct;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposInputValidValueToDiscountDollarCP64
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\DiscountProduct
 */
class AssertWebposInputValidValueToDiscountDollarCP64 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product)
    {
        $message_reg = "%s";
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf($message_reg, $webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($product->getName())->getText()),
            (string) $webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($product->getName())->getText(),
            'CategoryRepository - TaxClass - Discount Product -  Input value to discount by dollar'
        );
        $price_check = "%s";
        $price = substr($webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($product->getName())->getText(),6);
        $price_after = (float) $price-$price/2;
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf($price_check, $price_after),
            (string) $webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName()),
            'CategoryRepository - TaxClass - Discount Product -  Input value to discount by dollar'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "CategoryRepository - TaxClass - Discount Product - Input value to discount by dollar";
    }
}