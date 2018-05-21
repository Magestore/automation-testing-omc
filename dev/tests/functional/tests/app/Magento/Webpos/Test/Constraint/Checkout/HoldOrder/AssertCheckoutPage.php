<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 21/01/2018
 * Time: 11:07
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCheckoutPage
 * @package Magento\Webpos\Test\Constraint\Cart\HoldOrder
 */
class AssertCheckoutPage extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->isActivePageCheckout(),
            'Cart page is not active'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Cart page is correct";
    }
}