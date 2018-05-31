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

/**
 * Class WebposSync16Test
 * @package Magento\Webpos\Test\TestCase\Sync\Currency
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Login backend on another browser  > Configuration > Currency setup > Edit some fileds (ex: Default Display Currency )
 * 3. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to synchronization page
 * 2. Reload currency
 *
 * Acceptance Criteria
 * 2. Default Display Currency just selected will be used to checkout on Webpos page
 */
class WebposSync16Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * Store config Currency Setup page.
     *
     * @var ConfigCurrencySetup $configCurrencySetup
     */
    protected $configCurrencySetup;

    /**
     * System Currency Symbol grid page.
     *
     * @var SystemCurrencySymbolIndex $currencySymbolIndex
     */
    protected $currencySymbolIndex;

    /**
     * System currency index page.
     *
     * @var SystemCurrencyIndex $currencyIndex
     */
    protected $currencyIndex;

    /**
     * Fixture Factory.
     *
     * @var FixtureFactory $fixtureFactory
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