<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/8/2018
 * Time: 2:33 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertProductQtyInCart
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct
 */
    class AssertProductQtyInCart extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $qty
     */
    public function processAssert(WebposIndex $webposIndex, $qty)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutProductDetail()->isVisible(),
            'Product Detail Popup not closed.'
        );
        $productQtyOnCart = 1;
        if ($webposIndex->getCheckoutCartItems()->getFirstCartItemQty()->isVisible()){
            $productQtyOnCart = (integer) $webposIndex->getCheckoutCartItems()->getFirstCartItemQty()->getText();
        }
        \PHPUnit_Framework_Assert::assertEquals(
            $qty,
            $productQtyOnCart,
            'Product qty in cart is not correctly.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Product qty was correctly.';
    }
}