<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/12/2018
 * Time: 10:17 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\ShippingPriceTaxableGoodsAndShippingIncludingTax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting [Catalog Prices] = Including tax & [Enable Cross Border Trade] = Yes
 * Testcase TAX47 - Check tax amount on cart page and Checkout page
 *
 * Precondition:
 * Exist 2 tax rules: 1st tax rule meet to Shipping settings
 * 1. Go to Configuration >Sales >Tax >Tax Classes:
 * - [Catalog Prices] = Including tax
 * - [Enable Cross Border Trade] = Yes
 * Other fields: tick on [Use system value]
 * 2. Save config
 * 3. Go to Configuration > Sales> Tax > Shipping settings:
 * - Input [Origin]
 * 4. Save config
 * On webpos:
 * 1. Login Webpos as a staff
 *
 *
 * Steps
 * 1. Add a  product and select a customer to meet 1st tax rule
 * 2. Change shipping address of customer to meet 2nd tax rule
 * 3. Go to Checkout page
 *
 * Acceptance Criteria
 * 1.
 * product_price_excl_tax = [product_price_incl_tax] / (1+ [Origin_shipping_tax_rate])
 * tax amount = [product_price_excl_tax] *  [Origin_shipping_tax_rate]
 *
 * 2.
 * product_price_excl_tax = [product_price_incl_tax] / (1+ [tax_rate_current])
 * tax = [product_price_excl_tax] * [tax_rate_current]
 *
 * 3.
 * product_price_excl_tax = [product_price_incl_tax] / (1+ [tax_rate_current])
 * tax = [product_price_excl_tax] * [tax_rate_current]
 *
 * Class WebposTaxTAX47Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX47Test extends Injectable
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
     * @var AssertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee
     */
    protected $assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee;

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

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee $assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee $assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee = $assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $taxRate
     * @return array
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $taxRate
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
        sleep(1);

        // Select Shipping Method
        $this->webposIndex->getCheckoutShippingMethod()->openCheckoutShippingMethod();
        $this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $shippingFee = $this->webposIndex->getCheckoutShippingMethod()->getShippingMethodPrice("Flat Rate - Fixed")->getText();
        $shippingFee = (float)substr($shippingFee, 1);

        //Assert Tax Amount on Cart Page
        $this->assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee->processAssert($taxRate, $shippingFee, $this->webposIndex);
        //End Assert Tax Amount on Cart Page

        // Change Shipping Method
        $this->webposIndex->getCheckoutShippingMethod()->getBestWayTableRate()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $this->webposIndex->getCheckoutShippingMethod()->waitForElementVisible('#tablerate_bestway');
        $shippingFee = $this->webposIndex->getCheckoutShippingMethod()->getShippingMethodPrice("Best Way - Table Rate")->getText();
        $shippingFee = (float)substr($shippingFee, 1);

        //Assert Tax Amount on Cart Page
        $this->assertTaxAmountAndShippingOnCartPageAndCheckoutPageWithShippingFee->processAssert($taxRate, $shippingFee, $this->webposIndex);
        //End Assert Tax Amount on Cart Page

        return [
            'products' => $products,
            'taxRate' => $taxRate
        ];
    }

    /**
     *
     */
    public function tearDown()
    {
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}