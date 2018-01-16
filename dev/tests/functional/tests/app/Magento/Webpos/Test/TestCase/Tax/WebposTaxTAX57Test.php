<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/15/2018
 * Time: 8:51 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposTaxTAX57Test extends Injectable
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
     * @var AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade
     */
    protected $assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade;

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
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset'=> 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Create CA Tax Rule
        $taxRule = $fixtureFactory->createByCode('taxRule', ['dataset'=> 'CA_rule']);
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
     * @param AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee $assertTaxAmountOnOrderHistoryInvoiceWithShippingFee
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade $assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade = $assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade;
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
        // Config [Catalog Prices] = Including tax & [Enable Cross Border Trade] = Yes
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'including_tax_and_enable_cross_border_trade']
        )->run();
        // Config Default Tax Destination Calculation California
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'california_default_tax_destination']
        )->run();
        // Login webpos
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
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade->processAssert(
            $this->webposIndex, $defaultTaxRate, $products[0]['product']);
        //Change customer address to Michigan
        $this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();
        $this->webposIndex->getCheckoutEditCustomer()->getEditShippingAddressIcon()->click();
        $this->webposIndex->getCheckoutEditAddress()->getRegionId()->setValue('Michigan');
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getToaster()->getWarningMessage();
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade->processAssert(
            $this->webposIndex, $currentTaxRate, $products[0]['product']);
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->assertProductPriceWithCatalogPriceInCludeTaxAndEnableCrossBorderTrade->processAssert(
            $this->webposIndex, $currentTaxRate, $products[0]['product']);
    }

    public function tearDown()
    {
        $this->objectManager->create('Magento\Webpos\Test\Handler\TaxRule\Curl')->persist($this->caTaxRule);
    }
}