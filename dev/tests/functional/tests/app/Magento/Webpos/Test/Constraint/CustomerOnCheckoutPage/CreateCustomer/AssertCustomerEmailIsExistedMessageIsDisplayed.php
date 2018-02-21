<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 11:08
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCustomerEmailIsExistedMessageIsDisplayed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			'The customer email is existed.',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			"Customer on checkout page - Create Customer - 'Customer email is existed' message is not displayed"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Create Customer - 'Customer email is existed' message is displayed";
	}
}