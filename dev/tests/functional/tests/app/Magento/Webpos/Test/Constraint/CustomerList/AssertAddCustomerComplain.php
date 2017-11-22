<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 09:05
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertAddCustomerComplain extends AbstractConstraint
{

    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            $result['success'],
            'The customer\'s complaint is saved successfully.'
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