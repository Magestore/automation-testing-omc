<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 2:17 PM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\BillingAddressPopup;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertAddBillingAddressPopupIsClosed
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\BillingAddressPopup
 */
class AssertAddBillingAddressPopupIsClosed extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        sleep(1);
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getCheckoutAddBillingAddress()->isVisible(),
            "Customer on checkout page - Billing address popup - Billing address popup is not closed"
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddCustomer()->isVisible(),
            "Customer on checkout page - Billing address popup - New customer popup is not shown"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Customer on checkout page - Billing address popup is closed";
    }
}