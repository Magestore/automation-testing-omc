<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 08:32
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCartPageCustomerCheckoutByNewCustomerTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
	 */
	protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

	public function __prepare()
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'webpos_default_guest_checkout_rollback']
		)->run();
	}

	public function __inject(
		WebposIndex $webposIndex,
		AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible

	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

	}

	public function test(
		Staff $staff,
		CatalogProductSimple $product,
		Customer $customer,
		Address $guestAddress = null,
		$addAddress = false
	)
	{
		// Login webpos
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep',
			['staff' => $staff]
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		// Create new customer
		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		self::assertTrue(
			$this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
			'Checkout - Cart Page - Change customer popup is not shown'
		);
		$this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
		self::assertTrue(
			$this->webposIndex->getCheckoutAddCustomer()->isVisible(),
			'Checkout - Cart Page - Add customer popup is not shown'
		);
		$this->webposIndex->getCheckoutAddCustomer()->getFirstNameInput()->setValue($customer->getFirstname());
		$this->webposIndex->getCheckoutAddCustomer()->getLastNameInput()->setValue($customer->getLastname());
		$this->webposIndex->getCheckoutAddCustomer()->getEmailInput()->setValue($customer->getEmail());
		$this->webposIndex->getCheckoutAddCustomer()->clickGroupSelect();
		$this->webposIndex->getCheckoutAddCustomer()->getCustomerGroupItem($customer->getGroupId())->click();
		// Add ship and bill address
		if ($addAddress) {
			$this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
			self::assertTrue(
				$this->webposIndex->getCheckoutAddShippingAddress()->isVisible(),
				'Checkout - Cart Page - Add shipping address popup is not shown'
			);
			$this->webposIndex->getCheckoutAddShippingAddress()->getFirstNameInput()->setValue($customer->getFirstname());
			$this->webposIndex->getCheckoutAddShippingAddress()->getLastNameInput()->setValue($customer->getLastname());
			$customerAddress = $customer->getAddress()[0];
			$this->webposIndex->getCheckoutAddShippingAddress()->getPhoneInput()->setValue($customerAddress['telephone']);
			$this->webposIndex->getCheckoutAddShippingAddress()->getStreet1Input()->setValue($customerAddress['street']);
			$this->webposIndex->getCheckoutAddShippingAddress()->getCityInput()->setValue($customerAddress['city']);
			$this->webposIndex->getCheckoutAddShippingAddress()->getZipCodeInput()->setValue($customerAddress['postcode']);
			$this->webposIndex->getCheckoutAddShippingAddress()->clickCountrySelect();
			$this->webposIndex->getCheckoutAddShippingAddress()->getCountryItem($customerAddress['country_id'])->click();
			$this->webposIndex->getCheckoutAddShippingAddress()->clickRegionSelect();
			$this->webposIndex->getCheckoutAddShippingAddress()->getRegionItem($customerAddress['region_id'])->click();
			$this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
			sleep(1);
		}

		$this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();
		sleep(1);
		//Assert Customer save success
		self::assertEquals(
			'The customer is saved successfully.',
			$this->webposIndex->getToaster()->getWarningMessage()->getText(),
			'Checkout - Cart Page - Add new customer - save message is wrong'
		);


		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		$this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		//Assert Place Order Success
		$this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

		$this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$name = $customer->getFirstname().' '.$customer->getLastname();
		if ($addAddress) {
			$addressText = $customerAddress['city'].', '.$customerAddress['region_id'].', '.$customerAddress['postcode'].', ';
			$phone = $customerAddress['telephone'];
		} else {
			$addressText = $guestAddress->getCity().', '.$guestAddress->getRegionId().', '.$guestAddress->getPostcode().', ';
			$phone = $guestAddress->getTelephone();
		}
		return [
			'name' => $name,
			'address' => $addressText,
			'phone' => $phone
		];
	}
}