<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 10:31
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckGUICustomPriceInsertNegativePriceCP55
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposCheckGUICustomPriceInsertNegativePriceCP55 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $negativeValue, $product)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($product->getName())->isVisible(),
            'TaxClass page - After set value to amount input with a negative value it must be change nothing. But It create more the original price exchange for price.'
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