<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 11:31
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCheckCartSimpleProduct
 * @package Magento\Webpos\Test\Constraint\Cart\HoldOrder
 */
class AssertCheckCartSimpleProduct extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $cartProducts)
    {
        if ($cartProducts == null) {
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getCheckoutCartItems()->isCartItem(),
                'Checkout is not default'
            );
        } else {
            foreach ($cartProducts as $key => $cartProduct) {
                $expectedPrice = floatval($cartProduct['price']*$cartProduct['qty']);
                \PHPUnit_Framework_Assert::assertEquals(
                    $cartProduct['name'],
                    $webposIndex->getCheckoutCartItems()->getNameCartItemByOrderTo($key+1),
                    'Name product is not correct'
                );

                \PHPUnit_Framework_Assert::assertEquals(
                    $expectedPrice,
                    $webposIndex->getCheckoutCartItems()->getPriceCartItemByOrderTo($key+1),
                    'Price product is not correct'
                );

                if (floatval($cartProduct['qty']) >1) {
                    \PHPUnit_Framework_Assert::assertTrue(
                        $webposIndex->getCheckoutCartItems()->isQtyDisplay($key+1),
                        'Qty is not display'
                    );
                    \PHPUnit_Framework_Assert::assertEquals(
                        floatval($cartProduct['qty']),
                        $webposIndex->getCheckoutCartItems()->getQtyDisplay($key+1),
                        'Qtu product is not display correct'
                    );
                }
            }
        }
    }



    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Product in Checkout is correct";
    }
}