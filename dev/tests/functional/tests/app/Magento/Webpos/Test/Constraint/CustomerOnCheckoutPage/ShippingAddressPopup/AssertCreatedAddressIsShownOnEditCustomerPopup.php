<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 13:12
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertCreatedAddressIsShownOnEditCustomerPopup
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup
 */
class AssertCreatedAddressIsShownOnEditCustomerPopup extends AbstractConstraint
{

	/**
	 * @param WebposIndex $webposIndex
	 * @param Address $address
	 */
	public function processAssert(WebposIndex $webposIndex, Address $address)
	{
		$country= [
			'United States' => 'US',
			'United Kingdom' => 'GB',
			'Germany' => 'DE'
		];

		$name = $address->getFirstname().' '.$address->getLastname();
		$addressText = $address->getStreet().' , '
			.$address->getCity().' , '
			.$address->getRegion().' , '
			.$country[$address->getCountryId()].' '
			.$address->getPostcode();
		$phone = $address->getTelephone();

		sleep(1);
		// Shipping Info
		\PHPUnit_Framework_Assert::assertEquals(
			$name,
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

		// Billing Info
		\PHPUnit_Framework_Assert::assertEquals(
			$name,
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

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Shipping address popup - The created address will be shown on Edit customer popup";
	}
}