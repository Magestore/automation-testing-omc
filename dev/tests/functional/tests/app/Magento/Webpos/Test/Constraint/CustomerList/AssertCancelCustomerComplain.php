<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 09:17
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Constraint\CustomerList;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertCancelCustomerComplain
 * @package Magento\Webpos\Test\Constraint\CustomerList
 */
class AssertCancelCustomerComplain extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCustomerListContainer()->getFormCustomerComplain()->isVisible(),
            'Cancel Customer Complain successfully.'
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
