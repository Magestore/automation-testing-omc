<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 14:53
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposPlaceOrderWithCustomPercentCP61
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposPlaceOrderWithCustomPercentCP61 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amountValue, $product, $price)
    {
        sleep(1);
        $priceOfProduct = $webposIndex->getOrderHistoryOrderViewContent()->getPriceOfProduct($product->getName())->getText();
        $priceOfProduct = substr($priceOfProduct, 1, 3);
        \PHPUnit_Framework_Assert::assertEquals(
            $amountValue*$price/100,
            $priceOfProduct,
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
        return 'TaxClass page - After set value to amount input with a negative value it work correctly.' ;
    }
}