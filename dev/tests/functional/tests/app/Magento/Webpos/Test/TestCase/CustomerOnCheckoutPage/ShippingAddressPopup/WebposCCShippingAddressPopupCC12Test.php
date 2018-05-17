<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 10:07
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\CreateCustomer\AssertCreateCustomerOnCheckoutPageSuccess;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertCreatedAddressIsShownOnEditCustomerPopup;
use Magento\Webpos\Test\Constraint\CustomerOnCheckoutPage\ShippingAddressPopup\AssertCreatedAddressIsShownOnNewCustomerPopup;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCCShippingAddressPopupCC12Test extends Injectable
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
	 * @var AssertCreateCustomerOnCheckoutPageSuccess
	 */
	protected $assertCreateCustomerOnCheckoutPageSuccess;

	/**
	 * @var AssertCreatedAddressIsShownOnNewCustomerPopup
	 */
	protected $assertCreatedAddressIsShownOnNewCustomerPopup;

	/**
	 * @var AssertCreatedAddressIsShownOnEditCustomerPopup
	 */
	protected $assertCreatedAddressIsShownOnEditCustomerPopup;


	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertCreateCustomerOnCheckoutPageSuccess $assertCreateCustomerOnCheckoutPageSuccess,
		AssertCreatedAddressIsShownOnNewCustomerPopup $assertCreatedAddressIsShownOnNewCustomerPopup,
		AssertCreatedAddressIsShownOnEditCustomerPopup $assertCreatedAddressIsShownOnEditCustomerPopup
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertCreateCustomerOnCheckoutPageSuccess = $assertCreateCustomerOnCheckoutPageSuccess;
		$this->assertCreatedAddressIsShownOnNewCustomerPopup = $assertCreatedAddressIsShownOnNewCustomerPopup;
		$this->assertCreatedAddressIsShownOnEditCustomerPopup = $assertCreatedAddressIsShownOnEditCustomerPopup;
	}

	public function test(
		Customer $customer,
		Address $address
	)
	{
		$address = $this->prepareAddress($customer, $address);

		// LoginTest webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		$this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();

		$this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
		sleep(1);

		// fill customer info
        $this->webposIndex->getCheckoutAddCustomer()->waitForPopupVisible();
		$this->webposIndex->getCheckoutAddCustomer()->setFieldWithoutShippingAndBilling($customer->getData());

		$this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
		sleep(1);

		// Assert first name and last name is auto filled
		self::assertEquals(
			$customer->getFirstname(),
			$this->webposIndex->getCheckoutAddShippingAddress()->getFirstNameInput()->getValue(),
			"Customer on checkout page - shipping address popup - First name feild is not filled automatically"
		);
		self::assertEquals(
			$customer->getLastname(),
			$this->webposIndex->getCheckoutAddShippingAddress()->getLastNameInput()->getValue(),
			"Customer on checkout page - shipping address popup - First name feild is not filled automatically"
		);

		//fill shipping address info
        $this->webposIndex->getCheckoutAddShippingAddress()->waitForPopupVisible();
        $this->webposIndex->getCheckoutAddShippingAddress()->setFieldAddress($address->getData());

		$this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
		sleep(1);

		// Assert the created address will be shown on [Shipping address] and [Billing address] section
		$this->assertCreatedAddressIsShownOnNewCustomerPopup->processAssert($this->webposIndex, $address);

		$this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();

		// Assert create customer success
		$this->assertCreateCustomerOnCheckoutPageSuccess->processAssert($this->webposIndex, $customer);

		$this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();

		// Assert the created address will be shown on edit customer popup
		$this->assertCreatedAddressIsShownOnEditCustomerPopup->processAssert($this->webposIndex, $address);
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