<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/02/2018
 * Time: 09:13
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertBillingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertShippingAddressOnNewCustomerPopupIsCorrect;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCCShippingAddressPopupCC14CC16Test extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertShippingAddressOnNewCustomerPopupIsCorrect
	 */
	protected $assertShippingAddressOnNewCustomerPopupIsCorrect;

	/**
	 * @var AssertBillingAddressOnNewCustomerPopupIsCorrect
	 */
	protected $assertBillingAddressOnNewCustomerPopupIsCorrect;

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertShippingAddressOnNewCustomerPopupIsCorrect $assertShippingAddressOnNewCustomerPopupIsCorrect,
		AssertBillingAddressOnNewCustomerPopupIsCorrect $assertBillingAddressOnNewCustomerPopupIsCorrect
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertShippingAddressOnNewCustomerPopupIsCorrect = $assertShippingAddressOnNewCustomerPopupIsCorrect;
		$this->assertBillingAddressOnNewCustomerPopupIsCorrect = $assertBillingAddressOnNewCustomerPopupIsCorrect;
	}

	public function test(
		Customer $customer,
		Address $address,
		Address $editAddress,
		$sameShippingAndBillingAddress = 'Yes'
	)
	{
		$address = $this->prepareAddress($customer, $address);
		$editAddress = $this->prepareAddress($customer, $editAddress);

		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		$this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();

		$this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
//		sleep(3);

		// fill customer info
        $this->webposIndex->getCheckoutAddCustomer()->waitForPopupVisible();
		$this->webposIndex->getCheckoutAddCustomer()->setFieldWithoutShippingAndBilling($customer->getData());

		$this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
//		sleep(3);

		//fill shipping address info
        $this->webposIndex->getCheckoutAddShippingAddress()->waitForPopupVisible();
		$this->webposIndex->getCheckoutAddShippingAddress()->setFieldAddress($address->getData());

		$this->webposIndex->getCheckoutAddShippingAddress()->getSameBillingShippingCheckbox()->setValue('Yes');

		$this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
		sleep(1);

		// - The created shipping address will be shown on [Shipping address] section
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
		$this->assertShippingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);
		// Assert [Billing address] section is correct
		$this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);

		$this->webposIndex->getCheckoutAddCustomer()->getEditShippingAddressIcon()->click();
		sleep(3);

		//fill shipping address info
        $this->webposIndex->getCheckoutAddShippingAddress()->waitForPopupVisible();
		$this->webposIndex->getCheckoutAddShippingAddress()->setFieldAddress($editAddress->getData());

		$this->webposIndex->getCheckoutAddShippingAddress()->getSameBillingShippingCheckbox()->setValue($sameShippingAndBillingAddress);

		$this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();

		// Assert address changed
		$editAddressText = $editAddress->getFirstname().' '.$editAddress->getLastname().', '
			.$editAddress->getStreet().' '.$editAddress->getCity().', '
			.$country[$editAddress->getCountryId()].', '
			.$editAddress->getPostcode().', '
			.$editAddress->getTelephone();
		$this->assertShippingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $editAddressText);
		// Assert [Billing address] section is correct
		if ($sameShippingAndBillingAddress == 'No') {
			$this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $addressText);
		} elseif ($sameShippingAndBillingAddress == 'Yes') {
			$this->assertBillingAddressOnNewCustomerPopupIsCorrect->processAssert($this->webposIndex, $editAddressText);
		}
	}

	/**
	 * @param Customer $customer
	 * @param Address $address
	 * @return Address
	 */
	protected function prepareAddress(Customer $customer, Address $address)
	{
		$addressData = $address->getData();
		$addressData['firstname'] = $customer->getFirstname();
		$addressData['lastname'] = $customer->getLastname();
		$addressData['email'] = $customer->getEmail();
		return $this->fixtureFactory->createByCode('address', ['data' => $addressData]);
	}
}