<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/01/2018
 * Time: 16:06
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPage;

use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertBackToCartPage
 * @package Magento\Webpos\Test\Constraint\Cart\CartPage
 */
class AssertBackToCartPage extends AbstractConstraint
{
    public function processAssert($styleLeftBefore, $styleLeftAfter)
    {
        if($styleLeftAfter > $styleLeftBefore)
            $tag = 'Ok';
        else
            $tag = 'None';
        \PHPUnit_Framework_Assert::assertEquals('Ok',$tag,
            'Khong back');
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Back to cart page is default";
    }
}