<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 23:51
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Configuration;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Magento\Webpos\Test\Constraint\Synchronization\Configuration
 * AssertSynchronizationConfigColorSuccess
 */
class AssertSynchronizationDefaultPaymentSuccess extends AbstractConstraint
{
    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            $result['send-email-success'],
            'An email has been sent for this order'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            $result['notify-order-text'],
            'Order has been created successfully '.$result['order-id']
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Synchronization - Item Configuration for setting webpos default payment method Update/Reload Success";
    }
}