<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/12/2018
 * Time: 3:25 PM
 */

namespace Magento\Webpos\Test\TestCase\Tax\ShippingPriceTaxableGoodsAndShippingIncludingTax;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Tax\AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting [Catalog Prices] = Including tax & [Enable Cross Border Trade] = Yes
 * Testcase TAX50 - Check Tax amount on invoice popup
 *
 * Precondition:
 * Exist a rule tax meet to origin shipping address
 * In backend:
 * 1. Go to Configuration >Sales >Tax >Tax Classes:
 * - [Tax Class for Shipping] =  goods
 * - [Shipping Prices]= Including tax
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
 * 1. Add some  products and select  a customer to meet Shipping tax condition
 * 2. Go to Checkout page > select a shipping method with fee >0
 * 3. Place order successfully with:
 * + [Create invoice]: off
 * 4. Go to Order detail
 * 5. Click on [Invoice] button
 * 6. Click on [Submit invoice] button > OK
 *
 * Acceptance Criteria
 * 5.
 * Tax amount whole cart = Tax of products + Tax shipping
 * = (Subtotal * tax rate) + (Shipping fee * [Tax_rate :(1+ Tax_rate)]
 * 6. Create invoice successfully and show message: "Success: The invoice has been created successfully."
 *
 * Class WebposTaxTAX50Test
 * @package Magento\Webpos\Test\TestCase\Tax\ShippingPriceTaxableGoodsAndShippingIncludingTax
 */
class WebposTaxTAX50Test extends Injectable
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
     * @var AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee $assertTaxAmountOnOrderHistoryInvoiceWithShippingFee
     */
    protected $assertTaxAmountOnOrderHistoryInvoiceWithShippingFee;

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
     * @param AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee $assertTaxAmountOnOrderHistoryInvoiceWithShippingFee
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertTaxAmountOnOrderHistoryInvoiceWithShippingFee $assertTaxAmountOnOrderHistoryInvoiceWithShippingFee,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertTaxAmountOnOrderHistoryInvoiceWithShippingFee = $assertTaxAmountOnOrderHistoryInvoiceWithShippingFee;
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
        // Check out
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(0.5);
        // Select Shipping Method
        $this->webposIndex->getCheckoutShippingMethod()->openCheckoutShippingMethod();
        $this->webposIndex->getCheckoutShippingMethod()->waitForElementVisible('#flatrate_flatrate');
        $this->webposIndex->getCheckoutShippingMethod()->getFlatRateFixed()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(0.5);
        $shippingFee = $this->webposIndex->getCheckoutShippingMethod()->getShippingMethodPrice("Flat Rate - Fixed")->getText();
        $shippingFee = (float)substr($shippingFee, 1);
        // Select Payment Method
        $this->webposIndex->getCheckoutPaymentMethod()->waitForElementVisible('.icon-iconPOS-payment-cashforpos');
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(0.5);
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(0.5);
        // End Place Order
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success
        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Select Order
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {
        }
        self::assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
            "Order Content - Order Id is wrong"
            . "\nExpected: " . $orderId
            . "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
        );
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
        //Assert Tax Amount in Order History Invoice
        $this->assertTaxAmountOnOrderHistoryInvoiceWithShippingFee->processAssert($taxRate, $shippingFee, $products, $this->webposIndex);
        // Invoice order successfully
        $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        sleep(0.5);
        $this->webposIndex->getModal()->getOkButton()->click();
        return [
            'products' => $products,
            'taxRate' => $taxRate
        ];
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