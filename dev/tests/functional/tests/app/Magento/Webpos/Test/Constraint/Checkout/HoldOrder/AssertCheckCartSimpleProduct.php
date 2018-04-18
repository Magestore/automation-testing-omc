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

class AssertCheckCartSimpleProduct extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex,$cartProducts)
    {
        if ($cartProducts == null)
        {
            \PHPUnit_Framework_Assert::assertFalse($webposIndex->getCheckoutCartItems()->isCartItem(),
            'Cart is not default'

            );
        }else
        {
            for ($i = 0; $i < count($cartProducts); ++$i)
            {
                \PHPUnit_Framework_Assert::assertEquals(
                    $webposIndex->getCheckoutCartItems()->getNameCartItemByOrderTo($i+1),
                    $cartProducts[$i]['name'],
                    'Name product is not correct'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    $webposIndex->getCheckoutCartItems()->getPriceCartItemByOrderTo($i+1),
                    floatval($cartProducts[$i]['price']*$cartProducts[$i]['qty']),
                    'Price product is not correct'
                );

                if (floatval($cartProducts[$i]['qty']) >1)
                {
                    \PHPUnit_Framework_Assert::assertTrue(
                        $webposIndex->getCheckoutCartItems()->isQtyDisplay($i+1),
                        'Qty is not display'
                    );
                    \PHPUnit_Framework_Assert::assertEquals(
                        $webposIndex->getCheckoutCartItems()->getQtyDisplay($i+1),
                        floatval($cartProducts[$i]['qty']),
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
        return "Product in Cart is correct";
    }
}