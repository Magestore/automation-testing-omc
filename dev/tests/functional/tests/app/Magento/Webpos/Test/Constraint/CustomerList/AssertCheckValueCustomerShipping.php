<?php
/**
 * Created By thomas
 * Created At 12:30
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckValueCustomerShipping extends AbstractConstraint
{

    public function processAssert($result, WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertNotTrue(
            'Customer created successfully',
            $result['success-message'],
            'Success'
        );
        \PHPUnit_Framework_Assert::assertNotEmpty($result['first-name-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['last-name-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['company-name-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['phone-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['street-first-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['street-second-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['city-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['zip-code-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['country-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['province-address']);
        \PHPUnit_Framework_Assert::assertNotEmpty($result['vat-address']);
    }

    /**
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'We just saved customer information successfully.';
    }
}