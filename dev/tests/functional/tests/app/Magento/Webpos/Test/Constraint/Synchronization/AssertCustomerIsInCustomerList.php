<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/11/2017
 * Time: 15:48
 */

namespace Magento\Webpos\Test\Constraint\Synchronization;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerIsInCustomerList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Customer $customer, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->customerList();
		sleep(1);
		$webposIndex->getCustomerListContainer()->searchCustomer()->setValue($customer->getEmail());
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCustomerListContainer()->getFirstCustomer()->isVisible(),
			'Synchronization - Customer - '.$action.' - Customer is not found in customer list'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$customer->getFirstname(),
			$webposIndex->getCustomerListContainer()->getFirstName()->getText(),
			'Synchronization - Customer - '.$action.' - Customer First Name is not updated'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$customer->getLastname(),
			$webposIndex->getCustomerListContainer()->getLastName()->getText(),
			'Synchronization - Customer - '.$action.' - Customer Last Name is not updated'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$customer->getEmail(),
			$webposIndex->getCustomerListContainer()->getEmail()->getText(),
			'Synchronization - Customer - '.$action.' - sCustomer Email is not updated'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Customer - Customer is shown correctly in customer list";
	}
}
