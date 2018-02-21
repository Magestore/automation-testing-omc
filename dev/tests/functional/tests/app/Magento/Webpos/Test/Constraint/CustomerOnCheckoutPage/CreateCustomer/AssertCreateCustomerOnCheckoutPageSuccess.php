<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 11:21
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCreateCustomerOnCheckoutPageSuccess extends AbstractAssertForm
{
	public function processAssert(WebposIndex $webposIndex, Customer $customer)
	{

		\PHPUnit_Framework_Assert::assertEquals(
			"The customer is saved successfully.",
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Customer on checkout page - Create customer - Success message is wrong"
		);

		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getCheckoutAddCustomer()->isVisible(),
			"Customer on checkout page - Create Customer - New customer popup is not closed"
		);

		$fullname = $customer->getFirstname() . ' ' . $customer->getLastname();
		\PHPUnit_Framework_Assert::assertEquals(
			$fullname,
			$webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->getText(),
			'Customer on checkout page - Create customer - customer is not selected on cart page'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Create Customer success";
	}
}