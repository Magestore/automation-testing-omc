<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 10:00 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrdersHistoryOrderDetailAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewHeader()->titleOrderIdIsVisible(),
            'Orders Detail - Title Order ID is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->isVisible(),
            'Orders Detail - Icon Action Menu is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewContent()->billingAddressBlockIsVisible(),
            'Orders Detail - Billing Address is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewContent()->shippingAddressBlockIsVisible(),
            'Orders Detail - Shipping Address is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewContent()->paymentMethodBlockIsVisible(),
            'Orders Detail - Payment Method is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewContent()->shippingMethodBlockIsVisible(),
            'Orders Detail - Shipping Method is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryOrderViewContent()->itemTableIsVisible(),
            'Orders Detail - Product Table is not visible.'
        );

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Orders History page is available.';
    }
}