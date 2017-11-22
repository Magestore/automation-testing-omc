<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 08:48
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertSaveBlankCustomerComplain extends AbstractConstraint
{

    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            'Customer phone cannot be null',
            $result['complain-error'],
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
        return 'We cannot save the customer complain with any blank fields.';
    }
}