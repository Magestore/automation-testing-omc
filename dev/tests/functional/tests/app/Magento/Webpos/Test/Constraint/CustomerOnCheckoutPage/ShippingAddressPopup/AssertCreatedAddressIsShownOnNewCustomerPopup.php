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

/**
 * Class AssertCreatedAddressIsShownOnNewCustomerPopup
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup
 */
class AssertCreatedAddressIsShownOnNewCustomerPopup extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param Address $address
	 */
	public function processAssert(
		WebposIndex $webposIndex,
		Address $address
	)
	{
		$country= [
			'United States' => 'US',
			'United Kingdom' => 'GB',
			'Germany' => 'DE'
		];
		$addressText = $address->getFirstname().' '.$address->getLastname().', '
			.$address->getStreet().' '.$address->getCity().', '
			.$country[$address->getCountryId()].', '
			.$address->getPostcode().', '
			.$address->getTelephone();
//		\PHPUnit_Framework_Assert::assertEquals(
//			$address,
//			$webposIndex->getCheckoutAddCustomer()->getShippingAddressBox()->getText(),
//			"Customer on checkout page - Shipping address popup - Shipping address is not shown correct on new customer popup"
//		);
//		\PHPUnit_Framework_Assert::assertEquals(
//			$address,
//			$webposIndex->getCheckoutAddCustomer()->getBillingAddressBox()->getText(),
//			"Customer on checkout page - Shipping address popup - Billing address is not shown correct on new customer popup"
//		);
		$this->objectManager->create(AssertShippingAddressOnNewCustomerPopupIsCorrect::class)->processAssert($webposIndex, $addressText);
		$this->objectManager->create(AssertBillingAddressOnNewCustomerPopupIsCorrect::class)->processAssert($webposIndex, $addressText);
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