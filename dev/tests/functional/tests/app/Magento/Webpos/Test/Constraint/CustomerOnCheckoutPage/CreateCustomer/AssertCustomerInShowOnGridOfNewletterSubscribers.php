<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 13:42
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Newsletter\Test\Page\Adminhtml\SubscriberIndex;

class AssertCustomerInShowOnGridOfNewletterSubscribers extends AbstractConstraint
{
	public function processAssert(SubscriberIndex $subscriberIndex, Customer $customer)
	{
		$subscriberIndex->open();
		$filter = ['email' => $customer->getEmail()];
		\PHPUnit_Framework_Assert::assertTrue(
			$subscriberIndex->getSubscriberGrid()->isRowVisible($filter),
			"Created customer is not shown on the grid of Newsletter subcribers"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Create customer - Customer is shown on the grid of Newsletter subcribers";
	}
}