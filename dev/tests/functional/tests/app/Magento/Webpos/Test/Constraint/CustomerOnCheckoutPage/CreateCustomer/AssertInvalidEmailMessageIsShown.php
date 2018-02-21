<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 10:50
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertInvalidEmailMessageIsShown extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getCheckoutAddCustomer()->getEmailError()->isVisible(),
			"Customer on checkout page - Create customer - Email error is not shown"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			"Please enter a valid email address (Ex: johndoe@domain.com).",
			$webposIndex->getCheckoutAddCustomer()->getEmailError()->getText(),
			"Customer on checkout page - Create customer - Email error is wrong"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Create customer - Invalid email message is shown";
	}
}