<?php

/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/25/2018
 * Time: 3:55 PM
 */
namespace Magento\Webpos\Test\Constraint\OrderHistory\ReOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertItemsInCart
 * @package Magento\Webpos\Test\Constraint\OrderHistory\ReOrder
 */
class AssertItemsInCart extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        foreach ($products as $product) {
            \Zend_Debug::dump($product->getName());

            \PHPUnit_Framework_Assert::assertEquals(
                $product->getName(),
                $webposIndex->getCheckoutCartItems()->getCartItemName($product->getName()),
                "At the " . $product->getName() . 'was not correctly.'
            );
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Re-Order on checkout cart page was correctly.";
    }
}