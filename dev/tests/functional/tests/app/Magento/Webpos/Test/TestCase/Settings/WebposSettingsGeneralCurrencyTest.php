<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 28/09/2017
 * Time: 17:03
 */

namespace Magento\Webpos\Test\TestCase\Settings;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Config\Test\Page\Adminhtml\ConfigCurrencySetup;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencyIndex;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencySymbolIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSettingsGeneralCurrencyTest
 * @package Magento\Webpos\Test\TestCase\Settings
 */
class WebposSettingsGeneralCurrencyTest extends Injectable
{
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
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var CatalogProductSimple
	 */
	protected $product;

	/**
	 * @param ConfigCurrencySetup $configCurrencySetup
	 * @param SystemCurrencySymbolIndex $currencySymbolIndex
	 * @param SystemCurrencyIndex $currencyIndex
	 * @param FixtureFactory $fixtureFactory
	 * @param WebposIndex $webposIndex
	 * @return array
	 */
	public function __inject(
		configCurrencySetup $configCurrencySetup,
		SystemCurrencySymbolIndex $currencySymbolIndex,
		SystemCurrencyIndex $currencyIndex,
		FixtureFactory $fixtureFactory,
		WebposIndex $webposIndex

	)
	{
		$this->webposIndex = $webposIndex;
		$this->configCurrencySetup = $configCurrencySetup;
		$this->currencySymbolIndex = $currencySymbolIndex;
		$this->currencyIndex = $currencyIndex;
		$this->fixtureFactory = $fixtureFactory;
		$product = $this->fixtureFactory->createByCode(
			'catalogProductSimple',
			['dataset' => 'product_with_category']
		);
		$product->persist();
		$this->product = $product;

		return ['product' => $product];
	}

	public function test(Staff $staff, $configData, $currency, $rate, $symbol)
	{
		// Preconditions
		$this->importCurrencyRate($configData);

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}
		sleep(2);
		// Get Price before change currency
		// Checkout Page
		$this->webposIndex->getCheckoutPage()->search($this->product->getSku());
		$result['before-price'] = $this->webposIndex->getCheckoutPage()->getFirstProduct()->find('.price')->getText();
		$result['before-price'] = str_replace('$', '', $result['before-price']);
		$result['before-total'] = $this->webposIndex->getCheckoutPage()->getToTal2();
		$result['before-total'] = str_replace('$', '', $result['before-total']);
		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$this->webposIndex->getCheckoutPage()->selectPayment();
		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();
		sleep(1);
		$result['before-orderId'] = $this->webposIndex->getCheckoutPage()->getOrderId();
		$result['before-orderId'] = str_replace('#', '', $result['before-orderId']);
		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();
		sleep(1);

		//order history page
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();
		sleep(1);
		$this->webposIndex->getOrdersHistory()->search($result['before-orderId']);
		$result['before-orderHistory-price'] = $this->webposIndex->getOrdersHistory()->getPrice();
		$result['before-orderHistory-price'] = str_replace('$', '', $result['before-orderHistory-price']);

		// Change Currency
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->general();

		$this->webposIndex->getGeneral()->getCurrencyTab()->click();

		$this->webposIndex->getGeneral()->selectCurrency($currency);

		return [
			'currency' => $currency,
			'rate' => $rate,
			'symbol' => $symbol,
			'result' => $result
		];
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


	/**
	 * Disabling currency which has been added.
	 *
	 * @return void
	 */
	public function tearDown()
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'config_currency_symbols_usd']
		)->run();
	}
}