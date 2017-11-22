<?php
/**
 * Created by: thomas
 * Date: 02/11/2017
 * Time: 16:44
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 *
 */
class AssertAddCustomerAddress extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Create Customer Address - message is not displayed'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'The customer address is saved successfully.',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            'Create Customer Address successfully.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Success";
    }
}
