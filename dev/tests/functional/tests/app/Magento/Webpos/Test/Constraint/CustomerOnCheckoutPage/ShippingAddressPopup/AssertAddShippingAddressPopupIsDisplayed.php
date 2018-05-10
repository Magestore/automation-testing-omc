<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 08:35
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAddShippingAddressPopupIsDisplayed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->isVisible(),
			"Customer on checkout page - Shipping address popup is not displayed"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getFirstNameInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - First name field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getLastNameInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - Last name field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getCompanyInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - Company field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getPhoneInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - Phone field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getStreet1Input()->isVisible(),
			"Customer on checkout page - Shipping address popup - Street 1 field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getStreet2Input()->isVisible(),
			"Customer on checkout page - Shipping address popup - Street 2 field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getCityInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - City field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getZipCodeInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - Zip code field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getCountrySelect()->isVisible(),
			"Customer on checkout page - Shipping address popup - Country field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getRegionInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - State or Province input field is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getVATInput()->isVisible(),
			"Customer on checkout page - Shipping address popup - VAT field is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getSameBillingShippingCheckbox()->isVisible(),
			"Customer on checkout page - Shipping address popup - Same Billing and Shipping Checkbox is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getCancelButton()->isVisible(),
			"Customer on checkout page - Shipping address popup - Cancel button is not shown"
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->isVisible(),
			"Customer on checkout page - Shipping address popup - Save button is not shown"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Shipping address popup is displayed correctly";
	}
}