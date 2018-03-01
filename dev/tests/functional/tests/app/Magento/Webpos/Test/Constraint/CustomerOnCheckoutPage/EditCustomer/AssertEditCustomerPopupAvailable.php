<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/26/2018
 * Time: 10:03 AM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\EditCustomer;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertEditCustomerPopupAvailable extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getFirstNameInput()->isVisible(),
            'Customer first name input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getLastNameInput()->isVisible(),
            'Customer last name input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getEmailInput()->isVisible(),
            'Customer email input is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getCustomerGroup()->isVisible(),
            'Customer group is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getShippingAddressList()->isVisible(),
            'Shipping address list is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getBillingAddressList()->isVisible(),
            'Billing address list is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutEditCustomer()->getAddAddressButton()->isVisible(),
            'Add Address button is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Edit Customer Popup is available.';
    }
}