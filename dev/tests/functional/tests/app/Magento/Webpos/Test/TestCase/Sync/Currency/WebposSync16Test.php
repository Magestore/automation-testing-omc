<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/1/2018
 * Time: 8:10 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\Currency;

use Magento\Config\Test\Page\Adminhtml\ConfigCurrencySetup;
use Magento\CurrencySymbol\Test\Fixture\CurrencySymbolEntity;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencyIndex;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencySymbolIndex;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\CustomerComplain;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSync16Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
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
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param ConfigCurrencySetup $configCurrencySetup
     * @param SystemCurrencySymbolIndex $currencySymbolIndex
     * @param SystemCurrencyIndex $currencyIndex
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        ConfigCurrencySetup $configCurrencySetup,
        SystemCurrencySymbolIndex $currencySymbolIndex,
        SystemCurrencyIndex $currencyIndex
    )
    {
        $this->webposIndex = $webposIndex;
        $this->configCurrencySetup = $configCurrencySetup;
        $this->currencySymbolIndex = $currencySymbolIndex;
        $this->currencyIndex = $currencyIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @param Customer $customer
     * @param CustomerComplain $customerComplain
     * @param CustomerComplain $editCustomerComplain
     * @param CurrencySymbolEntity $currencySymbol
     * @param $configData
     */
    public function test(
        FixtureFactory $fixtureFactory,
        Customer $customer,
        CustomerComplain $customerComplain,
        CustomerComplain $editCustomerComplain,
        CurrencySymbolEntity $currencySymbol,
        $configData
    )
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->currencySymbolIndex->open();
        $this->currencySymbolIndex->getCurrencySymbolForm()->fill($currencySymbol);
        $this->currencySymbolIndex->getPageActions()->save();

        // Update Currency
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Customer Complaints")->click();
        sleep(5);
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'config_default_currency_rollback']
        )->run();
    }

}