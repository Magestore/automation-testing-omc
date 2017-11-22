<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 15:27
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertRefundSomeOrderOfAnyCustomer extends AbstractConstraint
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
        \PHPUnit_Framework_Assert::assertNotFalse(
            $result['refund-order'],
            'A creditmemo has been created!'
        );
    }

    /**
     * Text success save message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'Success';
    }
}