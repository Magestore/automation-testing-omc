<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/12/2017
 * Time: 13:18
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\Customer;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCartPageCustomerNameIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Customer $customer)
	{
		$fullName = $customer->getFirstname().' '.$customer->getLastname();
		\PHPUnit_Framework_Assert::assertEquals(
			$fullName,
			$webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->getText(),
			"CategoryRepository - TaxClass - Customer's name is wrong"
			. "\nExpected: " . $fullName
			. "\nActual: " . $webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->getText()
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "CategoryRepository - TaxClass - Customer's name is correct";
	}
}