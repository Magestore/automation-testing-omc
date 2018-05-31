<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/17/2018
 * Time: 8:33 AM
 */

namespace Magento\Webpos\Test\TestCase\Tax\TaxCalculationBasedOnShippingOrigin;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Webpos\Test\Constraint\Tax\AssertProductPriceOnOrderHistoryRefund;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Setting: [Tax Calculation Based On] = Shipping address
 * Testcase TAX75 - Check Tax amount on refund popup
 *
 * Precondition:
 * 1. Go to Configuration >Sales >Tax >Tax Classes:
 * - [Tax Calculation Based On] = Shipping Origin
 * - Other fields: tick on [Use system value]
 * 2. Save config
 * 3. Go to Configuration >Sales >Shipping settings
 * - Input Origin shipping address
 * 4. Save config
 * 5. Create a tax rule meet to [Default Guest Checkout] of Webpos
 * On webpos:
 * 1. Login Webpos as a staff
 *
 * Steps
 * 1. Add a  product to cart
 * 2. Place order successfully completed status
 * 3. Go to Order detail
 * 4. Click to open refund popup
 * 5. Refund order
 *
 * Acceptance Criteria
 * 4.  Price of each product = [Price * (1+ tax_rate) ]
 * 5. Refund order successfully
 *
 * Class WebposTaxTAX75Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX75Test extends Injectable
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
     * @var TaxRule $taxRuleCA
     */
    protected $taxRuleCA;

    /**
     * @var AssertProductPriceOnOrderHistoryRefund
     */
    protected $assertProductPriceOnOrderHistoryRefund;

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
        $taxRateCA = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-CA-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRateCA);

        $taxRateMI = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRateMI);

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
     * @param AssertProductPriceOnOrderHistoryRefund $assertProductPriceOnOrderHistoryRefund
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertProductPriceOnOrderHistoryRefund $assertProductPriceOnOrderHistoryRefund,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertProductPriceOnOrderHistoryRefund = $assertProductPriceOnOrderHistoryRefund;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
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

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        // End Place Order

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success

        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();

        sleep(2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();

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

        // Refund
        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        sleep(1);
        $this->webposIndex->getOrderHistoryAddOrderNote()->openRefundPopup();
        sleep(1);

        //Assert Tax Amount in Order History Invoice
        $this->assertProductPriceOnOrderHistoryRefund->processAssert($taxRates['taxRateCA']->getRate(), $products, $this->webposIndex);
        foreach ($products as $item) {
            if (isset($item['refundQty'])) {
                $this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($item['product']->getName())->setValue($item['refundQty']);
            }
        }
        // Refund successfully
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();

        return [
            'products' => $products,
            'taxRate' => $taxRates['taxRateCA']->getRate()
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

        // Delete Rax Rule
        $this->objectManager->create('Magento\Webpos\Test\Handler\TaxRule\Curl')->persist($this->taxRuleCA);
    }
}