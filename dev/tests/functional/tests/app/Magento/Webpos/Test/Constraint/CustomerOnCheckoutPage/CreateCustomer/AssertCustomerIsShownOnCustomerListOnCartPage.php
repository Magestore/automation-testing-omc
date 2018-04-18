<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 13:18
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerIsShownOnCustomerListOnCartPage extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Customer $customer)
	{
		$webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		$webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
		$webposIndex->getCheckoutChangeCustomer()->search($customer->getEmail());

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->isVisible(),
			'Customer on checkout page - Create Customer - customer is not found on customer list'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Create Customer - Customer is shown on customer list on cart page";
	}
}