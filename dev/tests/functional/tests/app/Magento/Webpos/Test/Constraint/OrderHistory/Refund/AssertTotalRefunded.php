<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/1/2018
 * Time: 4:49 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTotalRefunded extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $products, $refundShipping, $adjustRefund, $adjustFee)
    {
        $sumRowtotal = 0;
        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $rowTotal = substr($webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName), 1);
            $sumRowtotal += $rowTotal;
        }
        $totalPaid = substr($webposIndex->getOrderHistoryOrderViewFooter()->getTotalPaid(), 1);
        if (($sumRowtotal + $refundShipping + $adjustRefund - $adjustFee) < $totalPaid) {
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
            $totalRefund = $sumRowtotal + $refundShipping + $adjustRefund - $adjustFee;
            $webposIndex->getOrderHistoryOrderViewFooter()->waitForTotalRefundedVisible();
            $actualTotalRefunded = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getTotalRefunded(), 1);
            \PHPUnit_Framework_Assert::assertEquals(
                (float) $totalRefund,
                (float) $actualTotalRefunded,
                'Total Refunded is wrong'
                . "\nExpected: " . $totalRefund
                . "\nActual: " . $actualTotalRefunded
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
        return 'Total refunded is correct.';
    }
}