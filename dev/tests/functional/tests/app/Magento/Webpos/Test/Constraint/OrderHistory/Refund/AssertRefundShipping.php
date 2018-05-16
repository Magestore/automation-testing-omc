<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/1/2018
 * Time: 2:02 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertRefundShipping
 * @package Magento\Webpos\Test\Constraint\OrderHistory\Refund
 */
class AssertRefundShipping extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $refundShipping, $products, $testCaseId = null)
    {
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Success Message is not displayed'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'A creditmemo has been created!',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Success message's Content is Wrong"
        );
        $sumRowtotal = 0;
        sleep(1);
        if ($testCaseId != 'OH70') {
            foreach ($products as $item) {
                $productName = $item['product']->getName();
                $rowTotal = substr($webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName), 1);
                $sumRowtotal += $rowTotal;
            }
        }
        $totalRefund = $sumRowtotal + $refundShipping;
        $webposIndex->getOrderHistoryOrderViewFooter()->waitForTotalRefundedVisible();
        $actualTotalRefund = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getTotalRefunded(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            $totalRefund,
            $actualTotalRefund,
            'Total refund is not equal actual total refund.'
            . "\nExpected: " . $totalRefund
            . "\nActual: " . $actualTotalRefund
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Refund with shipping fee is correct.';
    }
}