<?php
/**
 * Created by: thomas
 * Date: 11/10/2017
 * Time: 15:41
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;

class AssertEditCustomerEntityTest extends AbstractConstraint
{

    public function processAssert($result)
    {
        \PHPUnit_Framework_Assert::assertNotFalse(
            $result['success'],
            'The customer is saved successfully.'
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