<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/25/2018
 * Time: 8:23 AM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderStatus;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertMassActionAvailableInOrderHistory extends AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex,
        $sendEmail = true,
        $ship = true,
        $cancel = true,
        $addComment = true,
        $reorder = true,
        $refund = true
    ){
        $webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        if ($sendEmail) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddOrderNote()->getSendMailButton()->isVisible(),
                'Send Email button is not visible.'
            );
        }
        if ($ship) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->isVisible(),
                'Ship button is not visible.'
            );
        } else {
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->isVisible(),
                'Ship button is visible.'
            );
        }
        if ($cancel) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddOrderNote()->getCancelButton()->isVisible(),
                'Cancel button is not visible.'
            );
        } else {
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryAddOrderNote()->getCancelButton()->isVisible(),
                'Cancel button is visible.'
            );
        }
        if ($addComment) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddOrderNote()->getAddCommentButton()->isVisible(),
                'Add Comment button is not visible.'
            );
        }
        if ($reorder) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddOrderNote()->getReOrderButton()->isVisible(),
                'Re-order button is not visible.'
            );
        }
        if ($refund) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->isVisible(),
                'Refund button is not visible.'
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
        return 'All massaction are available.';
    }
}