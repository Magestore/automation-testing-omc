<?php
/**
 * Created By thomas
 * Created At 07:32
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckout;

use Magento\Mtf\Constraint\AbstractConstraint;
/**
 * Class AssertCreateCustomerWithIncorrectInforCOC04
 * @package Magento\Webpos\Test\Constraint\CustomerList
 */
class AssertCreateCustomerWithIncorrectInforCOC04 extends AbstractConstraint
{

    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['first-name-error'],
            'At the Customer On Checkout Page that Customer First Name cannot be null'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['last-name-error'],
            'At the Customer On Checkout Page that Customer Last Name cannot be null'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['email-error'],
            'At the Customer On Checkout Page that Customer Email cannot be null'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['customer-group-error'],
            'At the Customer On Checkout Page that Customer Group cannot be null'
        );
    }

    /**
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'At the Customer On Checkout Page, We cannot save the customer with any blank field.';
    }
}