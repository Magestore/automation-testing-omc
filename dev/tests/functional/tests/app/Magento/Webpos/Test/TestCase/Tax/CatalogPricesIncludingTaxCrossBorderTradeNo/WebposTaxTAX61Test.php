<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 10:14 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\CatalogPricesIncludingTaxCrossBorderTradeNo;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting [Catalog Prices] = Including tax & [Enable Cross Border Trade] = No
 * Testcase TAX61 - Check Tax amount on cart page
 *
 * Precondition: Exist 2 tax rules: 1st tax rule meet to Shipping settings
 * 1. Go to Configuration >Sales >Tax >Tax Classes:
 * - [Catalog Prices] = Including tax
 * - [Enable Cross Border Trade] = No
 * Other fields: tick on [Use system value]
 * 2. Save config
 * 3. Go to Configuration > Sales> Tax >  Shipping settings:
 * - Input [Origin]
 * 4. Save config
 * On webpos:
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Add a  product and select a customer to meet 1st tax rule
 * 2. Change shipping address of customer to meet 2nd tax rule
 *
 * Acceptance Criteria
 * 1.
 * product_price_excl_tax = [product_price_incl_tax] / (1+ [default_tax_rate])
 * tax = [product_price_excl_tax] * [default_tax_rate]
 *
 * 2.
 * product_price_excl_tax = [product_price_incl_tax] / (1+ [default_tax_rate])
 * tax = [product_price_excl_tax] * [tax_rate_current]
 *
 * Class WebposTaxTAX61Test
 * @package Magento\Webpos\Test\TestCase\Tax\CatalogPricesIncludingTaxCrossBorderTradeNo
 */
class WebposTaxTAX61Test extends Injectable
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
     * @var TaxRule $caTaxRule
     */
    protected $caTaxRule;

    /**
     * @var AssertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade
     */
    protected $assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade;

    /**
     * Prepare data.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();

        // Change TaxRate
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Create CA Tax Rule
        $taxRule = $fixtureFactory->createByCode('taxRule', ['dataset' => 'CA_rule']);
        $taxRule->persist();
        $this->caTaxRule = $taxRule;

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_CA']);
        $customer->persist();

        return [
            'customer' => $customer
        ];
    }


    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade $assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade $assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade = $assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $defaultTaxRate float
     * @param $currentTaxRate float
     */
    public function test(
        Customer $customer,
        $products,
        $defaultTaxRate,
        $currentTaxRate
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Config [Catalog Prices] = Including tax & [Enable Cross Border Trade] = No
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'including_tax_and_disable_cross_border_trade']
        )->run();
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        // Change customer in cart meet California Tax
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        //Process assert product price and tax amount with default tax rate
        $actualPriceExcludeTax = $this->webposIndex->getCheckoutCartItems()->getCartItemPrice($products[0]['product']->getName())->getText();
        $actualPriceExcludeTax = substr($actualPriceExcludeTax, 1);
        $actualTaxAmount = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText();
        $actualTaxAmount = substr($actualTaxAmount, 1);
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade->processAssert(
            $this->webposIndex, $defaultTaxRate, $defaultTaxRate, $products[0]['product'], $actualPriceExcludeTax, $actualTaxAmount);
        //Change customer shipping address to Michigan
        $this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();
        $this->webposIndex->getCheckoutEditCustomer()->getEditShippingAddressIcon()->click();
        $this->webposIndex->getCheckoutEditAddress()->getRegionId()->setValue('Michigan');
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        sleep(3);
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getToaster()->getWarningMessage();
        $actualPriceExcludeTax = $this->webposIndex->getCheckoutCartItems()->getCartItemPrice($products[0]['product']->getName())->getText();
        $actualPriceExcludeTax = substr($actualPriceExcludeTax, 1);
        $actualTaxAmount = $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText();
        $actualTaxAmount = substr($actualTaxAmount, 1);
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndDisableCrossBorderTrade->processAssert(
            $this->webposIndex, $defaultTaxRate, $currentTaxRate, $products[0]['product'], $actualPriceExcludeTax, $actualTaxAmount);
    }

    public function tearDown()
    {
        $this->objectManager->create('Magento\Webpos\Test\Handler\TaxRule\Curl')->persist($this->caTaxRule);
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}