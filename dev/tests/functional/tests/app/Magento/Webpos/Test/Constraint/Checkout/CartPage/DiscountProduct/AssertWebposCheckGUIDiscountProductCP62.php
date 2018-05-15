<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/9/2018
 * Time: 10:07 AM
 */
namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\DiscountProduct;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckGUIDiscountProductCP62
 * @package Magento\Webpos\Test\Constraint\Checkout\CartPage\DiscountProduct
 */
class AssertWebposCheckGUIDiscountProductCP62 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            (float) 0,
            (float) $webposIndex->getCheckoutProductEdit()->getAmountInput()->getText(),
            'CategoryRepository Product Edit. On Tab Discount. Input Amout is not equal to zero.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$',
            (string) $webposIndex->getCheckoutProductEdit()->getActiveButton()->getText(),
            'CategoryRepository Product Edit. On Tab Discount. Not focus on $ option.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductEdit()->getDollarButton()->isVisible(),
            'CategoryRepository Product Edit. On Tab Discount. Icon Dollar is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductEdit()->getPercentButton()->isVisible(),
            'CategoryRepository Product Edit. On Tab Discount. Icon Percent is not show.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "TaxClass page is default";
    }
}