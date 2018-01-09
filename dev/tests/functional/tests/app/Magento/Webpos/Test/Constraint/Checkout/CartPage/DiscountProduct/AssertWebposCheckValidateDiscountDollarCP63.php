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

class AssertWebposCheckValidateDiscountDollarCP63 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, CatalogProductSimple $product)
    {
        $message = "Warning: You are able to apply discount under 100% only";
        \PHPUnit_Framework_Assert::assertEquals(
            sprintf($message),
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'CategoryRepository - TaxClass - Edit Product Qty - Minimum qty allow warning message is wrong'
            . "\nExpected: " . sprintf($message, $product->getName())
            . "\nActual: " . $webposIndex->getToaster()->getWarningMessage()->getText()
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