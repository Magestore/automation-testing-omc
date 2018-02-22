<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 11:02
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Customer\Test\Fixture\Address;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCreatedAddressIsShownOnNewCustomerPopup extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, Address $address)
	{
		$country= [
			'United States' => 'US',
			'United Kingdom' => 'GB',
			'Germany' => 'DE'
		];
		$address = $address->getFirstname().' '.$address->getLastname().', '
			.$address->getStreet().' '.$address->getCity().', '
			.$country[$address->getCountryId()].', '
			.$address->getPostcode().', '
			.$address->getTelephone();
		\PHPUnit_Framework_Assert::assertEquals(
			$address,
			$webposIndex->getCheckoutAddCustomer()->getShippingAddressBox()->getText(),
			"Customer on checkout page - Shipping address popup - Shipping address is not shown correct on new customer popup"
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$address,
			$webposIndex->getCheckoutAddCustomer()->getBillingAddressBox()->getText(),
			"Customer on checkout page - Shipping address popup - Billing address is not shown correct on new customer popup"
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Customer on checkout page - Shipping address popup - created address is shown on [Shipping address] and [Billing address] section";
	}
}