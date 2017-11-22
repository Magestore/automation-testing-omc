<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/11/2017
 * Time: 15:41
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertCustomerIsInCustomerList;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationCustomerTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * Customer grid page.
	 *
	 * @var CustomerIndex
	 */
	protected $customerIndexPage;

	/**
	 * Customer edit page.
	 *
	 * @var CustomerIndexEdit
	 */
	protected $customerIndexEditPage;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertCustomerIsInCustomerList
	 */
	protected $assertCustomerIsInCustomerList;

	public function __inject(
		WebposIndex $webposIndex,
		CustomerIndex $customerIndexPage,
		CustomerIndexEdit $customerIndexEditPage,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertCustomerIsInCustomerList $assertCustomerIsInCustomerList
	)
	{
		$this->webposIndex = $webposIndex;
		$this->customerIndexPage = $customerIndexPage;
		$this->customerIndexEditPage = $customerIndexEditPage;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertCustomerIsInCustomerList = $assertCustomerIsInCustomerList;
	}

	public function test(
		Staff $staff,
		Customer $customer,
		Customer $editCustomer
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

		// Add new Customer
		$customer->persist();

		// Reload Customer
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$customerText = "Customer";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($customerText)->click();

		// Assert Customer reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $customerText, $action);
		$this->assertCustomerIsInCustomerList->processAssert($this->webposIndex, $customer, $action);

		// Edit Created Customer in backend
		$filter = ['email' => $customer->getEmail()];
		$this->customerIndexPage->open();
		$this->customerIndexPage->getCustomerGridBlock()->searchAndOpen($filter);
		$this->customerIndexEditPage->getCustomerForm()->updateCustomer($editCustomer);
		$this->customerIndexEditPage->getPageActionsBlock()->save();

		// Update Customer
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($customerText)->click();

		$customer = $this->prepareCustomer($editCustomer, $customer);
		// Assert Customer update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $customerText, $action);
		$this->assertCustomerIsInCustomerList->processAssert($this->webposIndex, $customer, $action);

	}

	/**
	 * Prepares customer returned after test.
	 *
	 * @param Customer $customer
	 * @param Customer $initialCustomer
	 * @param Address|null $address
	 * @param Address|null $addressToDelete
	 * @return Customer
	 */
	private function prepareCustomer(
		Customer $customer,
		Customer $initialCustomer,
		Address $address = null,
		Address $addressToDelete = null
	) {
		$data = $customer->hasData()
			? array_replace_recursive($initialCustomer->getData(), $customer->getData())
			: $initialCustomer->getData();
		$groupId = $customer->hasData('group_id') ? $customer : $initialCustomer;
		$data['group_id'] = ['customerGroup' => $groupId->getDataFieldConfig('group_id')['source']->getCustomerGroup()];

		if ($initialCustomer->hasData('address')) {
			$addressesList = $initialCustomer->getDataFieldConfig('address')['source']->getAddresses();
			foreach ($addressesList as $key => $addressFixture) {
				if ($addressToDelete === null || $addressFixture != $address) {
					$data['address'] = ['addresses' => [$key => $addressFixture]];
				}
			}
		}
		if ($address !== null) {
			$data['address']['addresses'][] = $address;
		}

		return $this->fixtureFactory->createByCode(
			'customer',
			['data' => $data]
		);
	}
}