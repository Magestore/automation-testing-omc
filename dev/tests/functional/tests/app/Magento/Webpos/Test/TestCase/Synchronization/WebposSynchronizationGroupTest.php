<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 30/10/2017
 * Time: 15:16
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Customer\Test\Fixture\CustomerGroup;
use Magento\Customer\Test\Page\Adminhtml\CustomerGroupIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerGroupNew;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\Group\AssertCustomerGroupIsInGroupList;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationGroupTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * Page CustomerGroupIndex
	 *
	 * @var CustomerGroupIndex
	 */
	protected $customerGroupIndex;

	/**
	 * Page CustomerGroupNew
	 *
	 * @var CustomerGroupNew
	 */
	protected $customerGroupNew;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertCustomerGroupIsInGroupList
	 */
	protected $assertCustomerGroupIsInGroupList;

	public function __inject(
		WebposIndex $webposIndex,
		CustomerGroupIndex $customerGroupIndex,
		CustomerGroupNew $customerGroupNew,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertCustomerGroupIsInGroupList $assertCustomerGroupIsInGroupList
	)
	{
		$this->webposIndex = $webposIndex;
		$this->customerGroupIndex = $customerGroupIndex;
		$this->customerGroupNew = $customerGroupNew;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertCustomerGroupIsInGroupList = $assertCustomerGroupIsInGroupList;
	}

	public function test(
		Staff $staff,
		CustomerGroup $customerGroup,
		CustomerGroup $editCustomerGroup
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

		// Add new Shift
		$customerGroup->persist();

		// Reload Shift
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$groupText = "Group";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($groupText)->click();

		// Assert Group reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $groupText, $action);
		$this->assertCustomerGroupIsInGroupList->processAssert($this->webposIndex, $customerGroup, $action);

		// Edit Customer Group
		$filter = ['code' => $customerGroup->getCustomerGroupCode()];

		// Steps
		$this->customerGroupIndex->open();
		$this->customerGroupIndex->getCustomerGroupGrid()->searchAndOpen($filter);
		$this->customerGroupNew->getPageMainForm()->fill($editCustomerGroup);
		$this->customerGroupNew->getPageMainActions()->save();

		// Update Shift
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($groupText)->click();

		// Assert Shift update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $groupText, $action);
		$this->assertCustomerGroupIsInGroupList->processAssert($this->webposIndex, $editCustomerGroup, $action);

	}
}