<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/02/2018
 * Time: 07:58
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractAssertForm;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertShippingAddressOnNewCustomerPopupIsCorrect
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup
 */
class AssertShippingAddressOnNewCustomerPopupIsCorrect extends AbstractAssertForm
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $addressText
	 */
	public function processAssert(WebposIndex $webposIndex, $addressText)
	{
		if (empty($addressText)) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getCheckoutAddCustomer()->getShippingAddressBox()->isVisible(),
				"New customer popup - Shipping address is not blank"
			);
		} else {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCheckoutAddCustomer()->getShippingAddressBox()->isVisible(),
				"New customer popup - Shipping address is blank"
			);

			\PHPUnit_Framework_Assert::assertEquals(
				$addressText,
				$webposIndex->getCheckoutAddCustomer()->getShippingAddressBox()->getText(),
				"New customer popup - Shipping address is not shown correct on new customer popup"
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
		return "New customer popup - Shipping address is correct";
	}
}