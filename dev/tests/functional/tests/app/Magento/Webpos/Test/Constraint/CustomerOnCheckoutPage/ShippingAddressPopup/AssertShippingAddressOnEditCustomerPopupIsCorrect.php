<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/02/2018
 * Time: 11:27
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertShippingAddressOnEditCustomerPopupIsCorrect
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup
 */
class AssertShippingAddressOnEditCustomerPopupIsCorrect extends AbstractConstraint
{

	/**
	 * @param WebposIndex $webposIndex
	 * @param $fullname
	 * @param $addressText
	 * @param $phone
	 */
	public function processAssert(WebposIndex $webposIndex, $fullname, $addressText, $phone)
	{
		if (empty($addressText)) {
			\PHPUnit_Framework_Assert::assertFalse(
				$webposIndex->getCheckoutEditCustomer()->getShippingAddressBox()->isVisible(),
				"New customer popup - Shipping address is not blank"
			);
		} else {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getCheckoutEditCustomer()->getShippingAddressBox()->isVisible(),
				"New customer popup - Shipping address is blank"
			);

			\PHPUnit_Framework_Assert::assertEquals(
				$fullname,
				$webposIndex->getCheckoutEditCustomer()->getShippingName()->getText(),
				'Customer on checkout page - Edit customer popup - Shipping name is wrong'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$addressText,
				$webposIndex->getCheckoutEditCustomer()->getShippingAddress()->getText(),
				'Customer on checkout page - Edit customer popup - Shipping address is wrong'
			);
			\PHPUnit_Framework_Assert::assertEquals(
				$phone,
				$webposIndex->getCheckoutEditCustomer()->getShippingPhone()->getText(),
				'Customer on checkout page - Edit customer popup - Shipping phone is wrong'
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
		return "Edit customer popup - Shipping address is correct";
	}
}