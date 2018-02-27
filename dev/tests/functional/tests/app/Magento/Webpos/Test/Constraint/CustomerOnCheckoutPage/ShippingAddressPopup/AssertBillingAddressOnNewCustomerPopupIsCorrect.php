<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/02/2018
 * Time: 08:03
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertBillingAddressOnNewCustomerPopupIsCorrect
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup
 */
class AssertBillingAddressOnNewCustomerPopupIsCorrect extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $addressText
	 */
	public function processAssert(WebposIndex $webposIndex, $addressText)
	{
		if (empty($addressText)) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getCheckoutAddCustomer()->getBillingAddressBox()->isVisible(),
				"New customer popup - Billing address is not blank"
			);
		} else {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCheckoutAddCustomer()->getBillingAddressBox()->isVisible(),
				"New customer popup - Billing address is blank"
			);

			\PHPUnit_Framework_Assert::assertEquals(
				$addressText,
				$webposIndex->getCheckoutAddCustomer()->getBillingAddressBox()->getText(),
				"New customer popup - Billing address is not shown correct on new customer popup"
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
		return "New customer popup - Billing address is correct";
	}
}