<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 14:38
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCustomPriceWithValidValueCP60
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposCustomPriceWithValidValueCP60 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amountValue, $product, $price)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $amountValue*$price/10,
            $webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName()),
            'TaxClass page - Customer Price Percent - After set value to amount input with a valid value. The price is not automatically update correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Successfully. TaxClass page - Customer Price Percent - After set value to amount input with a valid value. The price was automatically update correctly.';
    }
}