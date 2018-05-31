<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/16/2018
 * Time: 1:09 PM
 */

namespace Magento\Webpos\Test\TestCase\Tax\IncludeFPTInSubtotalYes;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountWithIncludeFptInSubtotal;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting: Setting: [Include FPT In Subtotal] = Yes
 * Testcase TAX107 - Check tax amount on cart page and Checkout page
 *
 * Precondition:
 * In backend:
 * 1. Go to Configuration >Sales >Tax >Fixed Product Taxes
 * -  Setting: http://docs.magento.com/m2/ce/user_guide/tax/fixed-product-tax-configuration.html
 * -  [Include FPT In Subtotal] = Yes
 * - Other fields: tick on [Use system value]
 * 2. Save config
 * On webpos:
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Add a  product and select a customer to meet FTP tax
 * 2. Check tax amount
 * 3. Click on [Checkout] button
 * 4. Check tax amount on Checkout page
 * 5. Place order
 *
 * Acceptance Criteria
 * 2.
 * Tax amount = [product_price_excl_tax] * [tax_rate]
 * 4.
 * Tax amount = [product_price_excl_tax] * [tax_rate]
 * Subtotal = ([unit_price] + [fixed_product_tax]) * [qty]
 * Grandtotal = ([unit_price] - [discount] + [fixed_product_tax]) * [qty] + Tax_amount
 * 5. Place order successfully
 *
 * Class WebposTaxTAX107Test
 * @package Magento\Webpos\Test\TestCase\Tax\IncludeFPTInSubtotalYes
 */
class WebposTaxTAX107Test extends Injectable
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
     * @var TaxRule $caTaxRule
     */
    protected $caTaxRule;

    /**
     * @var AssertTaxAmountWithIncludeFptInSubtotal $assertTaxAmountWithIncludeFptInSubtotal
     */
    protected $assertTaxAmountWithIncludeFptInSubtotal;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

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
        $miTaxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($miTaxRate);

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'taxRate' => $miTaxRate->getRate()
        ];
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertTaxAmountWithIncludeFptInSubtotal $assertTaxAmountWithIncludeFptInSubtotal
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountWithIncludeFptInSubtotal $assertTaxAmountWithIncludeFptInSubtotal,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountWithIncludeFptInSubtotal = $assertTaxAmountWithIncludeFptInSubtotal;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $shippingTaxRate
     */
    public function test(
        Customer $customer,
        $products,
        $taxRate
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Config [Include FPT In Subtotal] = Yes and [Enable FPT] = Yes
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'include_FPT_in_subtotal_and_enable_fpt']
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
        // Change customer in cart meet Michigan Tax and FPT tax
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        sleep(2);
        $actualTaxAmount = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText(), 1);
        $actualSubtotal = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(), 1);
        $actualGrandtotal = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText(), 1);
        $this->assertTaxAmountWithIncludeFptInSubtotal->processAssert($products[0]['product']->getPrice(), $taxRate, $products[0]['product']->getFpt()[0]['price'], $actualTaxAmount, $actualSubtotal, $actualGrandtotal);
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $actualTaxAmount = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText(), 1);
        $actualSubtotal = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(), 1);
        $actualGrandtotal = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Total')->getText(), 1);
        $this->assertTaxAmountWithIncludeFptInSubtotal->processAssert($products[0]['product']->getPrice(), $taxRate, $products[0]['product']->getFpt()[0]['price'], $actualTaxAmount, $actualSubtotal, $actualGrandtotal);
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => true,
                'shipped' => false
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
    }

    public function tearDown()
    {
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();
    }
}