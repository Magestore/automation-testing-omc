<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/02/2018
 * Time: 13:15
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertBillingAddressOnEditCustomerPopupIsCorrect extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $fullname, $addressText, $phone)
	{
		if (empty($addressText)) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getCheckoutEditCustomer()->getBillingAddressBox()->isVisible(),
				"New customer popup - Billing address is not blank"
			);
		} else {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCheckoutEditCustomer()->getBillingAddressBox()->isVisible(),
				"New customer popup - Billing address is blank"
			);

			\PHPUnit_Framework_Assert::assertEquals(
				$fullname,
				$webposIndex->getCheckoutEditCustomer()->getBillingName()->getText(),
				'Customer on checkout page - Edit customer popup - Billing name is wrong'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$addressText,
				$webposIndex->getCheckoutEditCustomer()->getBillingAddress()->getText(),
				'Customer on checkout page - Edit customer popup - Billing address is wrong'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$phone,
				$webposIndex->getCheckoutEditCustomer()->getBillingPhone()->getText(),
				'Customer on checkout page - Edit customer popup - Billing phone is wrong'
			);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Edit customer popup - Billing address is correct";
	}
}