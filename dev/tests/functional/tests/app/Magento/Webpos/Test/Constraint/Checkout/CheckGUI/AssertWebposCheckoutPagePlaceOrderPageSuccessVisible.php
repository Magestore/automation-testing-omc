<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 09:34
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
 * @package Magento\WebposCheckGUICustomerPriceCP54EntityTest\Test\Constraint\CategoryRepository\CheckGUI
 */
class AssertWebposCheckoutPagePlaceOrderPageSuccessVisible extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Order has been created successfully',
            $webposIndex->getCheckoutSuccess()->getSuccessOrderMessage()->getText(),
            'On the CategoryRepository Success Page - The SUCCESS ORDER MESSAGE at the web POS checkout success visible but was not correctly.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'Order ID:',
            $webposIndex->getCheckoutSuccess()->getSuccessOrderId()->getText(),
            'On the CategoryRepository Success Page - The SUCCESS ORDER MESSAGE at the web POS checkout success visible but was not correctly.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutSuccess()->getOrderId()->isVisible(),
            'On the CategoryRepository Success Page - The ORDER ID at the web POS checkout success was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutSuccess()->getCustomerEmail()->isVisible(),
            'On the CategoryRepository Success Page - The CUSTOMER EMAIL INPUT at the web POS checkout success was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutSuccess()->getSendEmailButton()->isVisible(),
            'On the CategoryRepository Success Page - The SEND EMAIL BUTTON at the web POS checkout success was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutSuccess()->getPrintButton()->isVisible(),
            'On the CategoryRepository Success Page - The PRINT BUTTON at the web POS checkout success was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutSuccess()->getNewOrderButton()->isVisible(),
            'On the CategoryRepository Success Page - The NEW ORDER BUTTON at the web POS checkout success was not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the CategoryRepository Success Page - The ORDER ID, ORDER MESSAGE, CUSTOMER EMAIL INPUT, SEND EMAIL, PRINT, NEW ORDER BUTTON at the web POS checkout success were not visible.';
    }
}