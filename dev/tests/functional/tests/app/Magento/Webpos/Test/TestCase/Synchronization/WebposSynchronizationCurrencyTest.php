<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 01/11/2017
 * Time: 16:16
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\CurrencySymbol\Test\Fixture\CurrencySymbolEntity;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Config\Test\Page\Adminhtml\ConfigCurrencySetup;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencyIndex;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencySymbolIndex;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\Currency\AssertCurrencyIsUsedInCheckoutPage;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;


class WebposSynchronizationCurrencyTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * Store config Currency Setup page.
	 *
	 * @var ConfigCurrencySetup
	 */
	protected $configCurrencySetup;

	/**
	 * System Currency Symbol grid page.
	 *
	 * @var SystemCurrencySymbolIndex
	 */
	protected $currencySymbolIndex;

	/**
	 * System currency index page.
	 *
	 * @var SystemCurrencyIndex
	 */
	protected $currencyIndex;

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
	 * @var AssertCurrencyIsUsedInCheckoutPage
	 */
	protected $assertCurrencyIsUsedInCheckoutPage;

	/**
	 * @var CurrencySymbolEntity
	 */
	protected $rollbackCurrencySymbol;

	/**
	 * Create simple product and inject pages.
	 *
	 * @param configCurrencySetup $configCurrencySetup
	 * @param SystemCurrencySymbolIndex $currencySymbolIndex
	 * @param SystemCurrencyIndex $currencyIndex
	 * @param FixtureFactory $fixtureFactory
	 * @return array
	 */
	public function __inject(
		WebposIndex $webposIndex,
		configCurrencySetup $configCurrencySetup,
		SystemCurrencySymbolIndex $currencySymbolIndex,
		SystemCurrencyIndex $currencyIndex,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertCurrencyIsUsedInCheckoutPage $assertCurrencyIsUsedInCheckoutPage
	) {
		$this->webposIndex = $webposIndex;
		$this->configCurrencySetup = $configCurrencySetup;
		$this->currencySymbolIndex = $currencySymbolIndex;
		$this->currencyIndex = $currencyIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertCurrencyIsUsedInCheckoutPage = $assertCurrencyIsUsedInCheckoutPage;
	}

	/**
	 * Import currency rates.
	 *
	 * @param string $configData
	 * @return void
	 * @throws \Exception
	 */
	protected function importCurrencyRate($configData)
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => $configData]
		)->run();

		//Click 'Save Config' on 'Config>>Currency Setup' page.
		$this->configCurrencySetup->open();
		$this->configCurrencySetup->getFormPageActions()->save();

		// Import Exchange Rates for currencies
		$this->currencyIndex->open();
		$this->currencyIndex->getCurrencyRateForm()->clickImportButton();
		$this->currencyIndex->getCurrencyRateForm()->fillCurrencyUSDUAHRate();
//		if ($this->currencyIndex->getMessagesBlock()->isVisibleMessage('warning')) {
//			throw new \Exception($this->currencyIndex->getMessagesBlock()->getWarningMessages());
//		}
		$this->currencyIndex->getFormPageActions()->save();
	}

	public function test(
		Staff $staff,
		$configData,
		$currency,
		$rate,
		$symbol,
		CurrencySymbolEntity $currencySymbol
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		// Set Default Currency in backend
		$this->importCurrencyRate($configData);

		// Reload Currency
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$itemText = "Currency";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Group reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$this->assertCurrencyIsUsedInCheckoutPage->processAssert($this->webposIndex, $currency, $rate, $symbol, $action);

		// Edit Default currency's symbol

		// Steps
		$this->currencySymbolIndex->open();
		$this->currencySymbolIndex->getCurrencySymbolForm()->fill($currencySymbol);
		$this->currencySymbolIndex->getPageActions()->save();

		// Update Currency
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();

		// Assert Currency update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$this->assertCurrencyIsUsedInCheckoutPage->processAssert($this->webposIndex, $currency, $rate, $currencySymbol->getCustomCurrencySymbol(), $action);

		$this->rollbackCurrencySymbol = $this->fixtureFactory->createByCode(
			'currencySymbolEntity',
			[
				'data' => array_merge(
					$currencySymbol->getData(),
					['custom_currency_symbol' => $symbol]
				)
			]
		);
	}

	/**
	 * Disabling currency which has been added.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		// reset Currency symbol
		$this->currencySymbolIndex->open();
		$this->currencySymbolIndex->getCurrencySymbolForm()->fill($this->rollbackCurrencySymbol);
		$this->currencySymbolIndex->getPageActions()->save();

		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'config_default_currency_uah_rollback']
		)->run();
	}
}