<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 13:21
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckGUICustomPricensertPriceValueCP57
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposCheckGUICustomPricensertPriceValueCP57 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amountValue, $product, $price)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $price,
            $webposIndex->getCheckoutCartItems()->getValueOriginalItemPrice($product->getName()),
            'TaxClass page - After set value to amount input with a valid value [Reg.] field must be changeless. But It was not visible correctly.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            $amountValue,
            $webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName()),
            'TaxClass page - After set value to amount input with a valid value the new price product must be equal to amount value. But It was not visible correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'TaxClass page - After set value to amount input with a valid value the new price product must be equal to amount value. It was visible successfully.';
    }
}