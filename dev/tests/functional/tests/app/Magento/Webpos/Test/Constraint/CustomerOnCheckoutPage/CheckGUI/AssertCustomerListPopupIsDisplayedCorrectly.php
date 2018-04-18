<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 08:42
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CheckGUI;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerListPopupIsDisplayedCorrectly extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->isVisible(),
			"Customer On Checkout Page - Customer list popup is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Create Customer button is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getUseGuestButton()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Use Guest button is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getSearchBox()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Search box is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getSearchBox()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Search box is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Customer List is empty"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getFirstCustomerName()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Customer name is not shown"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getFirstCustomerPhone()->isVisible(),
			"Customer On Checkout Page - Customer list popup - Customer phone is not shown"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer On Checkout Page - CheckGUI - Customer list popup is displayed correctly";
	}
}