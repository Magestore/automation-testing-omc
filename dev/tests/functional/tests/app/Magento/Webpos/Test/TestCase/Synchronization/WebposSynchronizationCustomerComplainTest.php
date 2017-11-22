<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/11/2017
 * Time: 13:43
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\CustomerComplain\AssertCustomerComplainIsDisplayed;
use Magento\Webpos\Test\Fixture\CustomerComplain;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationCustomerComplainTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * Fixture Factory.
	 *
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertCustomerComplainIsDisplayed
	 */
	protected $assertCustomerComplainIsDisplayed;

	/**
	 * @param Customer $customer
	 * @return array
	 */
	public function __prepare(
		Customer $customer
	)
	{
		$customer->persist();
		return ['customer' => $customer];
	}

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertCustomerComplainIsDisplayed $assertCustomerComplainIsDisplayed
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertCustomerComplainIsDisplayed = $assertCustomerComplainIsDisplayed;
	}

	public function test(
		Staff $staff,
		Customer $customer,
		CustomerComplain $customerComplain,
		CustomerComplain $editCustomerComplain
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		// Add new customer complain
		$customerComplain = $this->fixtureFactory->createByCode(
			'customerComplain',
			[
				'data' => array_merge(
					$customerComplain->getData(),
					['customer_email' => $customer->getEmail()]
				)
			]
		);
		$customerComplain->persist();

		// Reload Customer Complain
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$customerComplainText = "Customer Complaints";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($customerComplainText)->click();

		// Assert Customer Complain reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $customerComplainText, $action);
		$this->assertCustomerComplainIsDisplayed->processAssert($this->webposIndex, $customerComplain, $action);

		// Edit Customer Complain
		$customerComplain = $this->prepareCustomerComplain($editCustomerComplain, $customerComplain);
		$customerComplain->persist();

		// Update Customer Complain
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($customerComplainText)->click();

		// Assert Customer Complain update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $customerComplainText, $action);
		$this->assertCustomerComplainIsDisplayed->processAssert($this->webposIndex, $customerComplain, $action);
	}

	/**
	 * @param CustomerComplain $customerComplain
	 * @param CustomerComplain $initialCustomerComplain
	 * @return CustomerComplain
	 */
	protected function prepareCustomerComplain(CustomerComplain $customerComplain, CustomerComplain $initialCustomerComplain)
	{
		$data = [
			'data' => array_merge(
				$initialCustomerComplain->getData(),
				$customerComplain->getData()
			)
		];

		return $this->fixtureFactory->createByCode('customerComplain', $data);
	}
}