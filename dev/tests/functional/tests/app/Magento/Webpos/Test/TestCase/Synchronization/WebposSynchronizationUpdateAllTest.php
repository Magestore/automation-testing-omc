<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/10/2017
 * Time: 15:50
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertSynchronizationPageDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationUpdateAllTest extends Injectable
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
	 * Product page with a grid.
	 *
	 * @var CatalogProductIndex
	 */
	protected $productGrid;

	/**
	 * Page to update a product.
	 *
	 * @var CatalogProductEdit
	 */
	protected $editProductPage;

	/**
	 * @var AssertSynchronizationPageDisplay
	 */
	protected $assertSynchronizationPageDisplay;

	/**
	 * Inject FixtureFactory.
	 *
	 * @param FixtureFactory $fixtureFactory
	 * @return void
	 */
	public function __prepare(FixtureFactory $fixtureFactory)
	{
		$this->fixtureFactory = $fixtureFactory;
	}

	public function __inject(
		WebposIndex $webposIndex,
		CustomerIndex $customerIndexPage,
		CustomerIndexEdit $customerIndexEditPage,
		CatalogProductIndex $productGrid,
		CatalogProductEdit $editProductPage,
		AssertSynchronizationPageDisplay $assertSynchronizationPageDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->customerIndexPage = $customerIndexPage;
		$this->customerIndexEditPage = $customerIndexEditPage;
		$this->productGrid = $productGrid;
		$this->editProductPage = $editProductPage;
		$this->assertSynchronizationPageDisplay = $assertSynchronizationPageDisplay;
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

	public function test(
		Staff $staff,
		Customer $initialCustomer,
		Customer $customer,
		CatalogProductSimple $initialProduct,
		CatalogProductSimple $product
	)
	{
		// Precondition
		$initialCustomer->persist();
		$initialProduct->persist();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		$this->webposIndex->getCheckoutPage()->search($initialProduct->getName());
		self::assertTrue(
			$this->webposIndex->getCheckoutPage()->getFirstProduct()->isVisible(),
			"Created Product is absent"
		);

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->customerList();
		sleep(1);
		$this->webposIndex->getCustomerListContainer()->searchCustomer()->setValue($initialCustomer->getEmail());
		self::assertTrue(
			$this->webposIndex->getCustomerListContainer()->getFirstCustomer()->isVisible(),
			'Created Customer is absent'
		);

		// Edit Created Customer in backend
		$filter = ['email' => $initialCustomer->getEmail()];
		$this->customerIndexPage->open();
		$this->customerIndexPage->getCustomerGridBlock()->searchAndOpen($filter);
		$this->customerIndexEditPage->getCustomerForm()->updateCustomer($customer);
		$this->customerIndexEditPage->getPageActionsBlock()->save();


		// Edit Created Product in backend
		$filter = ['sku' => $initialProduct->getSku()];

		$this->productGrid->open();
		$this->productGrid->getProductGrid()->searchAndOpen($filter);
		$this->editProductPage->getProductForm()->fill($product);
		$this->editProductPage->getFormPageActions()->save();

		// Update All in frontend
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->assertSynchronizationPageDisplay->processAssert($this->webposIndex);

		$this->webposIndex->getSynchronization()->getUpdateAllButton()->click();

		return [
			'customer' => $this->prepareCustomer($customer, $initialCustomer),
		];
	}
}
