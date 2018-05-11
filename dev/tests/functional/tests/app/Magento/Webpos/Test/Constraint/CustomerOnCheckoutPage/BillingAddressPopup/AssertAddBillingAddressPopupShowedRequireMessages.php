<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 2:18 PM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\BillingAddressPopup;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertAddBillingAddressPopupShowedRequireMessages
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\BillingAddressPopup
 */
class AssertAddBillingAddressPopupShowedRequireMessages extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getFirstNameError()->isVisible(),
            "Customer on checkout page - Billing Address Popup - First Name error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getFirstNameError()->getText(),
            "Customer on checkout page - Billing Address Popup - First Name require message is wrong"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getLastNameError()->isVisible(),
            "Customer on checkout page - Billing Address Popup - Last Name error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getLastNameError()->getText(),
            "Customer on checkout page - Billing Address Popup - Last Name require message is wrong"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getPhoneError()->isVisible(),
            "Customer on checkout page - Billing Address Popup - Phone error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getPhoneError()->getText(),
            "Customer on checkout page - Billing Address Popup - Phone require message is wrong"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getStreet1Error()->isVisible(),
            "Customer on checkout page - Billing Address Popup - Street 1 error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getStreet1Error()->getText(),
            "Customer on checkout page - Billing Address Popup - Street 1 require message is wrong"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getCityError()->isVisible(),
            "Customer on checkout page - Billing Address Popup - City error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getCityError()->getText(),
            "Customer on checkout page - Billing Address Popup - City require message is wrong"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getZipcodeError()->isVisible(),
            "Customer on checkout page - Billing Address Popup - Zipcode error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getZipcodeError()->getText(),
            "Customer on checkout page - Billing Address Popup - Zipcode require message is wrong"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getCountryError()->isVisible(),
            "Customer on checkout page - Billing Address Popup - Country error message is not shown"
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'This is a required field.',
            $webposIndex->getCheckoutAddBillingAddress()->getCountryError()->getText(),
            "Customer on checkout page - Billing Address Popup - Country require message is wrong"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Customer on checkout page - Billing address popup - blank all field - required message are shown";
    }
}