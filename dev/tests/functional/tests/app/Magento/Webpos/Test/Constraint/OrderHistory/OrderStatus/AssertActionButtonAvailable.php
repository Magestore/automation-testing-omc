<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 4:18 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderStatus;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertActionButtonAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $takePayment = true, $print = true, $invoice = true)
    {
        if ($takePayment) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
                'Take Payment button is not visible.'
            );
        } else {
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible(),
                'Take Payment button is visible.'
            );
        }
        if ($print) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryOrderViewFooter()->getPrintButton()->isVisible(),
                'Print button is not visible.'
            );
        }
        if ($invoice) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->isVisible(),
                'Invoice button is not visible.'
            );
        } else {
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->isVisible(),
                'Invoice button is visible.'
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
        return 'All action button are available.';
    }
}