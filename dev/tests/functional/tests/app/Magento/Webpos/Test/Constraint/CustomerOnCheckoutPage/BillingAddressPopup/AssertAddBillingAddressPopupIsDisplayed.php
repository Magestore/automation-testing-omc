<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 2:07 PM
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\BillingAddressPopup;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAddBillingAddressPopupIsDisplayed extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->isVisible(),
            "Customer on checkout page - Billing address popup is not displayed"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getFirstNameInput()->isVisible(),
            "Customer on checkout page - Billing address popup - First name field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getLastNameInput()->isVisible(),
            "Customer on checkout page - Billing address popup - Last name field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getCompanyInput()->isVisible(),
            "Customer on checkout page - Billing address popup - Company field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getPhoneInput()->isVisible(),
            "Customer on checkout page - Billing address popup - Phone field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getStreet1Input()->isVisible(),
            "Customer on checkout page - Billing address popup - Street 1 field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getStreet2Input()->isVisible(),
            "Customer on checkout page - Billing address popup - Street 2 field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getCityInput()->isVisible(),
            "Customer on checkout page - Billing address popup - City field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getZipCodeInput()->isVisible(),
            "Customer on checkout page - Billing address popup - Zip code field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getCountrySelect()->isVisible(),
            "Customer on checkout page - Billing address popup - Country field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getRegionInput()->isVisible(),
            "Customer on checkout page - Billing address popup - State or Province input field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getVATInput()->isVisible(),
            "Customer on checkout page - Billing address popup - VAT field is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getCancelButton()->isVisible(),
            "Customer on checkout page - Billing address popup - Cancel button is not shown"
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutAddBillingAddress()->getSaveButton()->isVisible(),
            "Customer on checkout page - Billing address popup - Save button is not shown"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Customer on checkout page - Billing address popup is displayed correctly";
    }
}