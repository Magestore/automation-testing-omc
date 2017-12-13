<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 13:43
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomerPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposPlaceOrderWithCustomerPriceCP58
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomerPrice
 */
class AssertWebposPlaceOrderWithCustomerPriceCP58 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amountValue, $product)
    {
        \PHPUnit_Framework_Assert::assertContains(
            $amountValue,
            $webposIndex->getOrderHistoryOrderViewContent()->getPriceOfProduct($product->getName())->getText(),
            'Order History Detail - The new price of the product is not visible correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Cart page - After set value to amount input with a negative value it work correctly.' ;
    }
}