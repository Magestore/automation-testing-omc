<?php
/**
 * Created by: thomas
 * Date: 11/10/2017
 * Time: 15:21
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertEditCustomerBlankAllFields
 * @package Magento\Webpos\Test\Constraint\CustomerList
 */
class AssertEditCustomerBlankAllFields extends AbstractConstraint
{

    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['first-name'],
            'Customer First name cannot be null.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['last-name'],
            'Customer Last name cannot be null.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['email'],
            'Customer Email cannot be null.'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $result['customer-group'],
            'Customer group cannot be null.'
        );
    }

    /**
     * Text success save message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'Fail';
    }
}