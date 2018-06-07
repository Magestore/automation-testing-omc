<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/19/2018
 * Time: 2:10 PM
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckoutWithConfigProduct;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Payment\AssertPaymentSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\AssertOrderStatus;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Check tax amount when ordering with shipping fee
 * Testcase TAX17 - Check Tax amount on invoice popup
 *
 * Precondition:
 * 1. Go to backend > Configuration > Sales > Tax:
 * Setting all fields: tick on [Use system value] checkbox
 *
 * Steps
 * 1. Login webpos as a staff
 * 2. Add some  products and select a customer to meet tax condition
 * 3. Select a shipping method with fee
 * 4. Place order successfully with:
 * + [Mark a shipped]: off
 * + [Create invoice]: off
 * 5. Go to Order detail
 * 6. Click on [Invoice] button
 * 7. Click on [Submit invoice] button > OK
 *
 * Acceptance Criteria
 * 6.
 * - Tax amount of each product  = (their Subtotal - Discount) x Tax rate
 * - Rowtotal of each product = their Subtotal + Tax - Discount
 * - Tax amount whole cart = SUM(tax amount of each product)
 * - Subtotal whole cart = SUM(Subtotal  of each product)
 * - Grand total = Subtotal whole cart + Shipping + Tax - Discount
 * 7. Create invoice successfully and show message: "Success: The invoice has been created successfully."
 *
 * Class WebposTaxTAX117Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX117Test extends Injectable
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
     * @var AssertPaymentSuccess $assertPaymentSuccess
     */
    protected $assertPaymentSuccess;

    /**
     * @var AssertInvoiceSuccess $assertInvoiceSuccess
     */
    protected $assertInvoiceSuccess;

    /**
     * @var AssertShipmentSuccess $assertShipmentSuccess
     */
    protected $assertShipmentSuccess;

    /**
     * @var AssertRefundSuccess $assertRefundSuccess
     */
    protected $assertRefundSuccess;

    /**
     * @var AssertOrderStatus $assertOrderStatus
     */
    protected $assertOrderStatus;

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
     * @param AssertPaymentSuccess $assertPaymentSuccess
     * @param AssertInvoiceSuccess $assertInvoiceSuccess
     * @param AssertShipmentSuccess $assertShipmentSuccess
     * @param AssertRefundSuccess $assertRefundSuccess
     * @param AssertOrderStatus $assertOrderStatus
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertPaymentSuccess $assertPaymentSuccess,
        AssertInvoiceSuccess $assertInvoiceSuccess,
        AssertShipmentSuccess $assertShipmentSuccess,
        AssertRefundSuccess $assertRefundSuccess,
        AssertOrderStatus $assertOrderStatus,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertPaymentSuccess = $assertPaymentSuccess;
        $this->assertInvoiceSuccess = $assertInvoiceSuccess;
        $this->assertShipmentSuccess = $assertShipmentSuccess;
        $this->assertRefundSuccess = $assertRefundSuccess;
        $this->assertOrderStatus = $assertOrderStatus;
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
            'Magento\Webpos\Test\TestStep\CreateNewConfigurableProductsStep',
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
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        foreach ($products as $key => $item) {
            for ($i = 0; $i < $item['orderQty']; $i++) {
                $this->webposIndex->getCheckoutProductList()->search($products[$key]['product']->getSku());
                $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
                $this->webposIndex->getMsWebpos()->waitCartLoader();

                // Select options
                $attributes = $products[$key]['product']->getConfigurableAttributesData()['attributes_data'];
                foreach ($attributes as $attribute) {
                    $option = $attribute['options']['option_key_0']['label'];
                    if ($option === "") {
                        $option = $attribute['options']['option_key_0']['admin'];
                    }
                    $label = $attribute['label'];
                    $this->webposIndex->getCheckoutProductDetail()->selectAttributes($label, $option);
                }

                $this->webposIndex->getCheckoutProductDetail()->waitForAvailableQtyVisible();
                $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
            }
        }

        // Change customer in cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();

        // Check out and Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Placer Order
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // End Place Order

        // Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success

        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {
        }
        self::assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
            "Order Content - Order Id is wrong"
            . "\nExpected: " . $orderId
            . "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
        );

        sleep(4);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        sleep(3);
        $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->click();
        $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
        sleep(2);
        $this->webposIndex->getModal()->getOkButton()->click();

        //Assert Tax Amount in Order History Refund
        $this->assertPaymentSuccess->processAssert($this->webposIndex);

        sleep(1);
        // Invoice
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
        $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        sleep(2);
        $this->webposIndex->getModal()->getOkButton()->click();

        // Assert Invoice Success
        $this->assertInvoiceSuccess->processAssert($this->webposIndex);
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForProcessingStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Processing');

        sleep(1);
        // Shipment
        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryAddOrderNote()->openShipmentPopup();
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        sleep(2);
        $this->webposIndex->getModal()->getOkButton()->click();

        // Assert Shipment Success
        $this->assertShipmentSuccess->processAssert($this->webposIndex);
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForCompleteStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Complete');

        sleep(1);
        // Refund
        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryAddOrderNote()->openRefundPopup();
        $qty = $this->webposIndex->getOrderHistoryRefund()->getItemQty($products[0]['product']->getName());
        $this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($products[0]['product']->getName())->setValue($qty);
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        sleep(2);
        $this->webposIndex->getModal()->getOkButton()->click();

        // Assert Refund Success
        $this->assertRefundSuccess->processAssert($this->webposIndex, 'Closed');
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForClosedStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Closed');

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