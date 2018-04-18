<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/31/2018
 * Time: 10:36 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundPopupAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $shippingFee)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getCancelButton()->isVisible(),
            'Cancel button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getRefundOfflineButton()->isVisible(),
            'Refund Offline button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getSubmitButton()->isVisible(),
            'Submit Refund button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getSendEmailCheckbox()->isVisible(),
            'Send Email checkbox is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getCommentBox()->isVisible(),
            'Refund Comment area is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getAdjustRefundBox()->isVisible(),
            'Adjust Refund input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getAdjustFee()->isVisible(),
            'Adjust Fee input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getTableHeader('Product')->isVisible(),
            'Product column is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getTableHeader('Sku')->isVisible(),
            'Sku column is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getTableHeader('Price')->isVisible(),
            'Price column is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getTableHeader('Qty')->isVisible(),
            'Qty column is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getTableHeader('Qty to refund')->isVisible(),
            'Qty to refund is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOrderHistoryRefund()->getTableHeader('Return to stock')->isVisible(),
            'Return to stock is not visible.'
        );
        if ($shippingFee > 0) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryRefund()->getRefundShipping()->isVisible(),
                'Refund shipping input is not visible.'
            );
            $actualRefundShippingValue = $webposIndex->getOrderHistoryRefund()->getRefundShipping()->getValue();
            \PHPUnit_Framework_Assert::assertEquals(
                $shippingFee,
                $actualRefundShippingValue,
                'Refund shipping value is not equal actual default refund shipping value.'
                . "\nExpected: " . $shippingFee
                . "\nActual: " . $actualRefundShippingValue
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
        return 'Refund popup is available.';
    }
}