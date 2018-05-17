<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 21/02/2018
 * Time: 10:11
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\CreateCustomer;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCCCreateCustomerTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;


	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
	}

	public function test(
		Customer $customer = null,
		$action = 'save',
		$inputExistEmail = false,
		$subscribeNewsletter = false
	)
	{
		if ($inputExistEmail) {
			$existCustomer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'johndoe_MI_unique_first_name']);
			$existCustomer->persist();
		}

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

		if (isset($customer)) {
			$customerData = $customer->getData();
			if ($inputExistEmail) {
				$customerData['email'] = $existCustomer->getEmail();
			}
			$this->webposIndex->getCheckoutAddCustomer()->setFieldWithoutShippingAndBilling($customerData);
		}

		$subscribeNewsletterCheckbox = $this->webposIndex->getCheckoutAddCustomer()->getSubscribeSwitchBox();
		if ($subscribeNewsletterCheckbox->isVisible()) {
			if ($subscribeNewsletter != $this->webposIndex->getCheckoutAddCustomer()->isCheckboxChecked($subscribeNewsletterCheckbox)) {
				$subscribeNewsletterCheckbox->click();
			}
		}


		if (strcmp($action, 'cancel') == 0) {
			$this->webposIndex->getCheckoutAddCustomer()->getCancelButton()->click();
		} elseif (strcmp($action, 'save') == 0) {
			$this->webposIndex->getCheckoutAddCustomer()->getSaveButton()->click();
		}
	}
}