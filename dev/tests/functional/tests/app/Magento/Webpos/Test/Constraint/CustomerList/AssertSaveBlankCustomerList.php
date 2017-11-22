<?php
/**
 * Created By thomas
 * Created At 07:32
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSaveBlankCustomerList extends AbstractConstraint
{

    public function processAssert($result, WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Firstname cannot be null',
            $result['first-name-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Lastname cannot be null',
            $result['last-name-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Email cannot be null',
            $result['email-error'],
            'This is a required field.'
        );
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Group cannot be null',
            $result['customer-group-error'],
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
        return 'We cannot save the customer with blank form.';
    }
}