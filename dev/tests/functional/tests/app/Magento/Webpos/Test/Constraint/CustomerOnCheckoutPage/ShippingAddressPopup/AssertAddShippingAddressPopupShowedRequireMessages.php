<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 09:05
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAddShippingAddressPopupShowedRequireMessages extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getFirstNameError()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - First Name error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getFirstNameError()->getText(),
			"Customer on checkout page - Shipping Address Popup - First Name require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getLastNameError()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - Last Name error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getLastNameError()->getText(),
			"Customer on checkout page - Shipping Address Popup - Last Name require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getPhoneError()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - Phone error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getPhoneError()->getText(),
			"Customer on checkout page - Shipping Address Popup - Phone require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getStreet1Error()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - Street 1 error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getStreet1Error()->getText(),
			"Customer on checkout page - Shipping Address Popup - Street 1 require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getCityError()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - City error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getCityError()->getText(),
			"Customer on checkout page - Shipping Address Popup - City require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getZipcodeError()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - Zipcode error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getZipcodeError()->getText(),
			"Customer on checkout page - Shipping Address Popup - Zipcode require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddShippingAddress()->getCountryError()->isVisible(),
			"Customer on checkout page - Shipping Address Popup - Country error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddShippingAddress()->getCountryError()->getText(),
			"Customer on checkout page - Shipping Address Popup - Country require message is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Shipping address popup - blank all field - required message are shown";
	}
}