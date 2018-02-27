<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 10:30
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRequireMessagesAreDisplayedUnderRequiredFeilds extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getFirstNameError()->isVisible(),
			"Customer on checkout page - Create Customer - First Name error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddCustomer()->getFirstNameError()->getText(),
			"Customer on checkout page - Create Customer - First Name require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getLastNameError()->isVisible(),
			"Customer on checkout page - Create Customer - Last Name error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddCustomer()->getLastNameError()->getText(),
			"Customer on checkout page - Create Customer - Last Name require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getEmailError()->isVisible(),
			"Customer on checkout page - Create Customer - Email error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddCustomer()->getEmailError()->getText(),
			"Customer on checkout page - Create Customer - Email require message is wrong"
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getCustomerGroupError()->isVisible(),
			"Customer on checkout page - Create Customer - Customer Group error message is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'This is a required field.',
			$webposIndex->getCheckoutAddCustomer()->getCustomerGroupError()->getText(),
			"Customer on checkout page - Create Customer - Customer Group require message is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Create Customer - Require messages are shown";
	}
}