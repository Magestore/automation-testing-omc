<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/18/2018
 * Time: 4:39 PM
 */

namespace Magento\Webpos\Test\TestCase\Tax\IncludeFPTInSubtotalNo;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountAndSubtotalWithIncludeFpt;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting: [Include FPT In Subtotal] = No
 * Testcase TAX112 - Check tax amount on cart page and Checkout page
 *
 * Precondition:
 * In backend:
 * 1. Go to Configuration >Sales >Tax >Fixed Product Taxes
 * -  Setting: http://docs.magento.com/m2/ce/user_guide/tax/fixed-product-tax-configuration.html
 * -  [Include FPT In Subtotal] = No
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
 * Subtotal = [unit_price]  * [qty]
 * 4. Subtotal and Tax amount are changless
 * 5. Place order successfully
 *
 *
 * Class WebposTaxTAX112Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX112Test extends Injectable
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
     * @var AssertTaxAmountAndSubtotalWithIncludeFpt
     */
    protected $assertTaxAmountAndSubtotalWithIncludeFpt;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
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
     * @param AssertTaxAmountAndSubtotalWithIncludeFpt $assertTaxAmountAndSubtotalWithIncludeFpt
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountAndSubtotalWithIncludeFpt $assertTaxAmountAndSubtotalWithIncludeFpt,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountAndSubtotalWithIncludeFpt = $assertTaxAmountAndSubtotalWithIncludeFpt;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $taxRate
     * @param bool $createInvoice
     * @param bool $shipped
     * @return array
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $taxRate,
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

        // Get values on page
        $actualTaxAmount = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText(), 1);
        $actualSubtotal = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(), 1);

        // Assert Tax Amount With Include Fpt In Subtotal on Checkout out page
        $this->assertTaxAmountAndSubtotalWithIncludeFpt
            ->processAssert($products[0]['product']->getPrice(), $taxRate, $actualTaxAmount, $actualSubtotal);

        // Check out
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        // Get values on page
        $actualTaxAmount = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Tax')->getText(), 1);
        $actualSubtotal = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Subtotal')->getText(), 1);

        // Assert Tax Amount With Include Fpt In Subtotal on Check out page
        $this->assertTaxAmountAndSubtotalWithIncludeFpt
            ->processAssert($products[0]['product']->getPrice(), $taxRate, $actualTaxAmount, $actualSubtotal);
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // End Place Order
        sleep(1);

        // Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success

        return [
            'products' => $products,
            'taxRate' => $taxRate
        ];
    }

    /**
     * After Test
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