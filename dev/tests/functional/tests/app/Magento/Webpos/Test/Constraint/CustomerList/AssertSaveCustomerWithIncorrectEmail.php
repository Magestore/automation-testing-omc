<?php
/**
 * Created By thomas
 * Created At 08:22
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSaveCustomerWithIncorrectEmail extends AbstractConstraint
{

    public function processAssert($result, WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer Email is incorrect',
            $result['incorrect-email'],
            'Please enter a valid email address (Ex: johndoe@domain.com).'
        );
    }

    /**
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'We cannot save the customer with incorrect email.';
    }
}