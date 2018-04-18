<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 09:07
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CheckGUI;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertNewCustomerPopupIsDisplayed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->isVisible(),
			"Customer On Checkout Page - New Customer popup is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getCancelButton()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Cancel is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getSaveButton()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Save is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getFirstNameInput()->isVisible(),
			"Customer On Checkout Page - New Customer popup - First name textbox is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getLastNameInput()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Last name textbox is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getEmailInput()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Email textbox is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getCustomerGroup()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Customer Group select is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getSubscribeSwitchBox()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Subscribe Switch Box is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Add shipping address icon is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getAddBillingAddressIcon()->isVisible(),
			"Customer On Checkout Page - New Customer popup - Add billing address icon is not shown"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer On Checkout Page - CheckGUI - New Customer popup is displayed correctly";
	}
}