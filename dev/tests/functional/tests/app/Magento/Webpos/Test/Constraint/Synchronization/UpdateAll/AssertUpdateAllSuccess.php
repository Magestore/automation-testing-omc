<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 26/10/2017
 * Time: 14:42
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\UpdateAll;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertUpdateAllSuccess extends AbstractConstraint
{
	public function processAssert(
		WebposIndex $webposIndex,
		CatalogProductSimple $product,
		Customer $customer
	)
	{
		sleep(20);

		$webposIndex->getCheckoutPage()->search($product->getName());
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getFirstProduct()->isVisible(),
			'Product name is not updated'
		);
		$webposIndex->getCheckoutPage()->search($product->getSku());
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutPage()->getFirstProduct()->isVisible(),
			'Product SKU is not updated'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			(float)$product->getPrice(),
			(float) $webposIndex->getCheckoutPage()->getFirstProductPrice(),
			'Product Price is not updated'
		);

		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->customerList();
		sleep(1);
		$webposIndex->getCustomerListContainer()->searchCustomer()->setValue($customer->getEmail());
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCustomerListContainer()->getFirstCustomer()->isVisible(),
			'Not found Customer'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$customer->getFirstname(),
			$webposIndex->getCustomerListContainer()->getFirstName()->getText(),
			'Customer First Name is not updated'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$customer->getLastname(),
			$webposIndex->getCustomerListContainer()->getLastName()->getText(),
			'Customer Last Name is not updated'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$customer->getEmail(),
			$webposIndex->getCustomerListContainer()->getEmail()->getText(),
			'Customer Email is not updated'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Update All: Success";
	}
}
