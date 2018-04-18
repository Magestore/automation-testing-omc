<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 21/01/2018
 * Time: 11:51
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckCartConfigProduct extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $cartProducts)
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
                    floatval($cartProducts[$i]['configurable_attributes_data']['matrix']['attribute_key_0:option_key_0']['price']),
                    'Price product is not correct'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    $webposIndex->getCheckoutCartItems()->getAttributeCartItemByOrderTo($i+1),
                    $cartProducts[$i]['configurable_attributes_data']['attributes_data']['attribute_key_0']['options']['option_key_0']['admin'],
                    'Attribute product is not correct'
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
        return "Product in Cart is correct";
    }
}