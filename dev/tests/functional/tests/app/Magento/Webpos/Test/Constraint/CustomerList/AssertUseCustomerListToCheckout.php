<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 08:26
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertUseCustomerListToCheckout
 * @package Magento\Webpos\Test\Constraint\CustomerList
 */
class AssertUseCustomerListToCheckout extends AbstractConstraint
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
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'Success';
    }
}