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
 * Class WebposTaxTAX117Test
 * @package Magento\Webpos\Test\TestCase\Tax
 */
class WebposTaxTAX117Test extends Injectable
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
     * @var AssertPaymentSuccess
     */
    protected $assertPaymentSuccess;

    /**
     * @var AssertInvoiceSuccess
     */
    protected $assertInvoiceSuccess;

    /**
     * @var AssertShipmentSuccess
     */
    protected $assertShipmentSuccess;

    /**
     * @var AssertRefundSuccess
     */
    protected $assertRefundSuccess;

    /**
     * @var AssertOrderStatus
     */
    protected $assertOrderStatus;

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
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset'=> 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }



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
                foreach ($attributes as $attribute){
                    $option = $attribute['options']['option_key_0']['label'];
                    if($option === ""){
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
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();

        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        while (strcmp($this->webposIndex->getOrderHistoryOrderViewHeader()->getStatus(), 'Not Sync') == 0) {}
        self::assertEquals(
            $orderId,
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId(),
            "Order Content - Order Id is wrong"
            . "\nExpected: " . $orderId
            . "\nActual: " . $this->webposIndex->getOrderHistoryOrderViewHeader()->getOrderId()
        );

        sleep(4);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        sleep(1);
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