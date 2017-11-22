<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 07:55
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertBlankAllFieldsCustomerAddress extends AbstractConstraint
{

    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer phone cannot be null',
            $result['customer-phone-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer street cannot be null',
            $result['customer-street-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer city cannot be null',
            $result['customer-city-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer zipcode cannot be null',
            $result['customer-zipcode-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer country cannot be null',
            $result['customer-country-error'],
            'This is a required field.'
        );
    }

    /**
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'We cannot save the customer address with any blank fields.';
    }
}