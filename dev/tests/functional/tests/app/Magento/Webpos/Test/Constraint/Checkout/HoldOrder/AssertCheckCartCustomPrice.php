<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 21/01/2018
 * Time: 22:18
 */

namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckCartCustomPrice extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $cartProducts, $type, $priceCustom)
    {
        for ($i = 0; $i < count($cartProducts); ++$i) {
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getCheckoutCartItems()->getNameCartItemByOrderTo($i + 1),
                $cartProducts[$i]['name'],
                'Name product is not correct'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getCheckoutCartItems()->getOriginPriceCartItemByOrderToElement($i + 1)->isVisible(),
                'Price product is not display'
            );
            if ($webposIndex->getCheckoutCartItems()->getOriginPriceCartItemByOrderToElement($i + 1)->isVisible()) {
                \PHPUnit_Framework_Assert::assertEquals(
                    floatval($cartProducts[$i]['price'] * $cartProducts[$i]['qty']),
                    $webposIndex->getCheckoutCartItems()->getOriginPriceCartItemByOrderTo($i + 1),
                    'Price product is not correct'
                );
            }

            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getCheckoutCartItems()->findPriceCartItemByOrderToElement($i + 1)->isVisible(),
                'Price custom product is not display'
            );
            if ($type == '$') {
                if ($webposIndex->getCheckoutCartItems()->findPriceCartItemByOrderToElement($i + 1)->isVisible()) {
                    \PHPUnit_Framework_Assert::assertEquals(
                        $webposIndex->getCheckoutCartItems()->getPriceCartItemByOrderTo($i + 1),
                        floatval(floatval($priceCustom) * floatval($cartProducts[$i]['qty'])),
                        'Price custom product with $ is not correct'
                    );
                }
            } else if ($type == '%') {
                if ($webposIndex->getCheckoutCartItems()->findPriceCartItemByOrderToElement($i + 1)->isVisible()) {
                    \PHPUnit_Framework_Assert::assertEquals(
                        $webposIndex->getCheckoutCartItems()->getPriceCartItemByOrderTo($i + 1),
                        floatval(floatval($priceCustom) * floatval($cartProducts[$i]['price']) * floatval($cartProducts[$i]['qty'])),
                        'Price custom product with % is not correct'
                    );
                }
            }


            if (floatval($cartProducts[$i]['qty']) > 1) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $webposIndex->getCheckoutCartItems()->isQtyDisplay($i + 1),
                    'Qty is not display'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    $webposIndex->getCheckoutCartItems()->getQtyDisplay($i + 1),
                    floatval($cartProducts[$i]['qty']),
                    'Qtu product is not display correct'
                );
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
        return "Product custom price in Cart is correct";
    }
}