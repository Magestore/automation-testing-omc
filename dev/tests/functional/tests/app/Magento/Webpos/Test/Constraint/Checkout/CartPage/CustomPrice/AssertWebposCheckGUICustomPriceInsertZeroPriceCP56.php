<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 11:04
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckGUICustomPriceInsertZeroPriceCP56
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposCheckGUICustomPriceInsertZeroPriceCP56 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amountValue, $product, $price)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $price,
            $webposIndex->getCheckoutCartItems()->getValueOriginalItemPrice($product->getName()),
            'TaxClass page - After set value to amount input with a zero value it must be create more original price. But the original price is not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartItems()->getCartItemPrice($product->getName())->isVisible(),
            'TaxClass page - After set value to amount input with a zero value it must be create more original price. But the original price is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'TaxClass page - After set value to amount input with a negative value it work correctly.' ;
    }
}