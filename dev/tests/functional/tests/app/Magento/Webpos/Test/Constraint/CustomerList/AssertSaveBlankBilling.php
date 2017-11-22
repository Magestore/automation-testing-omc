<?php
/**
 * Created By thomas
 * Created At 09:15
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSaveBlankBilling extends AbstractConstraint
{
    public function processAssert($result, WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Firstname Of Shipping cannot be null',
            $result['first-name-billing'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Lastname Of Shipping cannot be null',
            $result['last-name-billing'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Phone Of Shipping cannot be null',
            $result['phone-billing'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Street Of Shipping cannot be null',
            $result['street-billing'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer City Of Shipping Of Shipping cannot be null',
            $result['city-billing'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Zip Code Of Shipping Of Shipping cannot be null',
            $result['zip-code-billing'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Country Of Shipping Of Shipping cannot be null',
            $result['country-billing'],
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
        return 'We cannot save the customer shipping with any blank fields.';
    }
}