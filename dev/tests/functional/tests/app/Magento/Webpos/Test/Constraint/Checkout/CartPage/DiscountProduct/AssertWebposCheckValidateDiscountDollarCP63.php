<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/9/2018
 * Time: 11:24 AM
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\DiscountProduct;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckValidateDiscountDollarCP63
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\DiscountProduct
 */
class AssertWebposCheckValidateDiscountDollarCP63 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product)
    {
        $message = "You are able to apply discount under 100% only";
        \PHPUnit_Framework_Assert::assertEquals(
            $message,
            (string) $webposIndex->getToaster()->getWarningMessage()->getText(),
            'CategoryRepository - TaxClass - Discount Product - You are able to apply discount under 100% only'
        );
        $message_reg = "%s";
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf($message_reg, $webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($product->getName())->getText()),
            (string) $webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($product->getName())->getText(),
            'CategoryRepository - TaxClass - Discount Product -  Amount field is filled automatically with amount equal price product'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "CategoryRepository - TaxClass - Discount Product - You are able to apply discount under 100% only";
    }
}