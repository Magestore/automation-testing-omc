<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/16/2018
 * Time: 2:13 PM
 */

namespace Magento\Webpos\Test\Constraint\Tax;

use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AssertRefundShippingOnOrderHistoryRefundWithShippingFee
 * @package Magento\Webpos\Test\Constraint\Tax
 */
class AssertRefundShippingOnOrderHistoryRefundWithShippingFee extends AbstractAssertForm
{

    /**
     * @param $taxRate
     * @param $shippingFee
     * @param WebposIndex $webposIndex
     */
    public function processAssert($taxRate, $shippingFee, WebposIndex $webposIndex)
    {
        $taxRate = (float) $taxRate / 100;

        $refundShipping = $shippingFee / (1 + $taxRate);
        $refundShipping = round($refundShipping, 2);

        $refundShippingOnPage = $webposIndex->getOrderHistoryRefund()->getItemRow();
        $refundShippingOnPage = (float) $refundShippingOnPage;

        \PHPUnit_Framework_Assert::assertEquals(
            $refundShipping,
            $refundShippingOnPage,
            'Popup Refund On Order Page - The Refund Shipping was not correctly.'
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Popup Refund On Order Page - The Refund Shipping was correctly";
    }
}