<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11/12/2017
 * Time: 15:28
 */

namespace Magento\Webpos\Test\Constraint\Checkout\MultiOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposMultiOrderCheckoutOn2ndCart
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Constraint\Checkout\MultiOrder
 */
class AssertWebposMultiOrderCheckoutOn2ndCart extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $firstCart, $orderNumber)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($orderNumber)->isVisible(),
            'On the AssertWebposCheckGUICustomerPriceCP54 Cart Header - The cart item with name\'s'.$orderNumber.' was visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutCartHeader()->getMultiOrderItem($firstCart)->isVisible(),
            'On the AssertWebposCheckGUICustomerPriceCP54 Cart Header - The cart item with name\'s'.$firstCart.' was visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "On the AssertWebposCheckGUICustomerPriceCP54 Cart Header - The cart item were visible correctly.";
    }
}