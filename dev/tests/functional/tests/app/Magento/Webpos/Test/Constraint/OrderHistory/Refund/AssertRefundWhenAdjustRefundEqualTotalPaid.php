<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/2/2018
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundWhenAdjustRefundEqualTotalPaid extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $adjustRefund)
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
        $webposIndex->getOrderHistoryOrderViewFooter()->waitForTotalRefundedVisible();
        $actualTotalRefunded = (float) substr($webposIndex->getOrderHistoryOrderViewFooter()->getTotalRefunded(), 1);
        \PHPUnit_Framework_Assert::assertEquals(
            (float) $adjustRefund,
            (float) $actualTotalRefunded,
            'Total Refunded is wrong'
            . "\nExpected: " . $adjustRefund
            . "\nActual: " . $actualTotalRefunded
        );
        $webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->isVisible(),
            'Action Refund is not hiden.'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryAddOrderNote()->getCancelButton()->isVisible(),
            'Action Cancel is not hiden.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Refund success.';
    }
}