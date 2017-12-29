<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 10:05
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckGUICustomPriceCP54
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposCheckGUICustomPriceCP54 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            (float) 0,
            (float) $webposIndex->getCheckoutProductEdit()->getAmountInput()->getText(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Price. Input Amout is not equal to zero.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            '$',
            (string) $webposIndex->getCheckoutProductEdit()->getActiveButton()->getText(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Price. Not focus on $ option.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductEdit()->getDollarButton()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Price. Icon Dollar is not show.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutProductEdit()->getPercentButton()->isVisible(),
            'TaxClass page - CategoryRepository Product Edit. On Tab Customer Price. Icon Percent is not show.'
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