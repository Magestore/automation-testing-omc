<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 14:21
 */

namespace Magento\Webpos\Test\Constraint\Checkout\MultiOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposMultiOrderAddProductAndCustomer
 * @package Magento\Webpos\Test\Constraint\Checkout\MultiOrder
 */
class AssertWebposMultiOrderAddProductAndCustomer extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products)
    {
        foreach ($products as $product) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->isVisible(),
                'On the Webpos Cart - The cart item with name\'s'.$product->getName().' was not visible.'
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
        return 'On the Webpos Cart - The cart item were visible successfully.';
    }
}