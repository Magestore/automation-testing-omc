<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 07:50
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\Country\AssertCountryListUpdated;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationCountryTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var SystemConfigEdit
	 */
	protected $systemConfigEdit;

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
	 * @var AssertCountryListUpdated
	 */
	protected $assertCountryListUpdated;

	public function __inject(
		WebposIndex $webposIndex,
		SystemConfigEdit $systemConfigEdit,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertCountryListUpdated $assertCountryListUpdated
	)
	{
		$this->webposIndex = $webposIndex;
		$this->systemConfigEdit = $systemConfigEdit;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertCountryListUpdated = $assertCountryListUpdated;
	}

	public function test(
		Staff $staff,
		$configDataDataset,
		$configDataDataset_2
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

		// Test Case: SYNC22
		// Allow some countries
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => $configDataDataset]
		)->run();

		$configData = $this->fixtureFactory->createByCode(
			'configData',
			['dataset' => $configDataDataset]
		);


		// Reload Country
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$itemText = "Country";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Country reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$countryList = array_keys($configData->getData('section')['general/country/allow']['value']);
		$this->assertCountryListUpdated->processAssert($this->webposIndex, $countryList, $action);


		// Test Case: SYNC23
		// Edit Country
		// Allow some countries
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => $configDataDataset_2]
		)->run();

		$configData = $this->fixtureFactory->createByCode(
			'configData',
			['dataset' => $configDataDataset_2]
		);

		// Update Customer Complain
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();

		// Assert Customer Complain update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$countryList = array_keys($configData->getData('section')['general/country/allow']['value']);
		$this->assertCountryListUpdated->processAssert($this->webposIndex, $countryList, $action);
	}

	public function tearDown()
	{
		$tabName = 'general';
		$groupName = 'country';
		$fieldName = 'allow';
		$value = 'Yes';

		$this->systemConfigEdit->open();
		$this->systemConfigEdit->getMyBlock()->setValueInheritCheckbox($tabName, $groupName, $fieldName, $value);
		$this->systemConfigEdit->getPageActions()->save();
	}
}