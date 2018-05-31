<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/15/2018
 * Time: 10:38 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\ShippingPriceTaxableGoodsAndShippingIncludingTax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnCartPageAndCheckoutPageWithShippingFee;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting [Catalog Prices] = Including tax & [Enable Cross Border Trade] = Yes
 * Testcase TAX56 - Check Tax amount when changing customer
 *
 * Precondition: Exist 2 tax rules: 1st tax rule meet to origin shipping address
 * In backend:
 * 1. Go to Configuration >Sales >Tax >Tax Classes:
 * - [Tax Class for Shipping] =  goods
 * - [Shipping Prices]= Including tax
 * - [Enable Cross Border Trade] = Yes
 *
 * Other fields: tick on [Use system value]
 * 2. Save config
 * 3. Go to Configuration > Sales> Shipping settings:
 * - Input origin shipping address
 * 4. Save config
 * On webpos:
 * 1. Login Webpos as a staff
 *
 *
 * Steps
 * 1. Add some  products and select a customer to meet 1st tax rule
 * 2. Go to Checkout page > select a shipping method with fee >0
 * 3. Change shipping address of customer to meet 2nd tax rule
 *
 * Acceptance Criteria
 * 2. Tax amount whole cart = Tax of products + Tax shipping
 * = (Subtotal * tax rate) + (Shipping fee * [Tax_rate :(1+ Tax_rate)]
 *
 * 3.Tax amount will be updated according to tax rate of 2nd tax rule
 * Tax amount whole cart = Tax of products + Tax shipping
 * = (Subtotal * new_tax rate) + (New_Shipping fee * [new_Tax_rate :(1+ New_Tax_rate)]
 *
 * Class WebposTaxTAX56Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX56Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var TaxRule $taxRuleCA
     */
    protected $taxRuleCA;

    /**
     * @var AssertTaxAmountOnCartPageAndCheckoutPageWithShippingFee $assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee
     */
    protected $assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee;

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
        $taxRateMI = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRateMI);
        // Change TaxRate
        $taxRateCA = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-CA-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRateCA);
        $taxRates = [
            'taxRateMI' => $taxRateMI,
            'taxRateCA' => $taxRateCA
        ];
        // Create CA Tax Rule
        $taxRule = $fixtureFactory->createByCode('taxRule', ['dataset' => 'CA_rule']);
        $taxRule->persist();
        $this->taxRuleCA = $taxRule;
        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();
        return [
            'customer' => $customer,
            'taxRates' => $taxRates
        ];
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertTaxAmountOnCartPageAndCheckoutPageWithShippingFee $assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountOnCartPageAndCheckoutPageWithShippingFee $assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee = $assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $taxRates
     * @param bool $createInvoice
     * @param bool $shipped
     * @return array
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $taxRates,
        $createInvoice = true,
        $shipped = false
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
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
        // Change customer in cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        // Check out
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        // Select Shipping Method
        $this->webposIndex->getCheckoutShippingMethod()->openCheckoutShippingMethod();
        $this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $shippingFee = $this->webposIndex->getCheckoutShippingMethod()->getShippingMethodPrice("Flat Rate - Fixed")->getText();
        $shippingFee = (float)substr($shippingFee, 1);
        //Assert Tax Amount on Cart Page
        $this->assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee->processAssert($taxRates['taxRateMI']->getRate(), $shippingFee, $this->webposIndex);
        //End Assert Tax Amount on Cart Page
        //Change customer address to California
        $this->webposIndex->getCheckoutCartHeader()->getCustomerTitleDefault()->click();
        sleep(0.5);
        $this->webposIndex->getCheckoutEditCustomer()->getEditShippingAddressIcon()->click();
        sleep(0.5);
        $this->webposIndex->getCheckoutEditAddress()->getRegionId()->setValue('California');
        sleep(0.5);
        $this->webposIndex->getCheckoutEditAddress()->getSaveButton()->click();
        sleep(0.5);
        $this->webposIndex->getCheckoutEditCustomer()->getSaveButton()->click();
        $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        //Assert Tax Amount on Cart Page
        $this->assertTaxAmountOnCartPageAndCheckoutPageWithShippingFee->processAssert($taxRates['taxRateCA']->getRate(), $shippingFee, $this->webposIndex);
        //End Assert Tax Amount on Cart Page
        return [
            'products' => $products,
            'taxRates' => $taxRates
        ];
    }

    public function tearDown()
    {
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();

        // Delete Rax Rule
        $this->objectManager->create('Magento\Webpos\Test\Handler\TaxRule\Curl')->persist($this->taxRuleCA);
    }
}