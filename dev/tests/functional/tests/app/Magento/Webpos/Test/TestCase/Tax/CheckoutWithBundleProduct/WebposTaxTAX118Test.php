<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/01/2018
 * Time: 08:18
 */

namespace Magento\Webpos\Test\TestCase\Tax\CheckoutWithBundleProduct;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\AssertOrderStatus;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Payment\AssertPaymentSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Check tax amount when ordering with shipping fee
 * Testcase TAX18 - Check tax amount on cart page and checkout page
 *
 * Precondition:
 * 1. Go to backend > Configuration > Sales > Tax:
 * Setting all fields: tick on [Use system value] checkbox
 * 1. Login Webpos as a staff
 *
 * Steps
 *  1. Login webpos as a staff
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
 *
 * Class WebposTaxTAX118Test
 * @package Magento\Webpos\Test\TestCase\Tax\CheckoutWithBundleProduct
 */
class WebposTaxTAX118Test extends Injectable
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
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'johndoe_MI_unique_first_name']);
        $customer->persist();

        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_tax_configuration_use_system_value']
        )->run();

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
     * @param $taxRate
     * @param $products
     * @param bool $createInvoice
     * @param bool $shipped
     * @param $dataConfig
     * @return array
     */
    public function test(
        Customer $customer,
        $taxRate,
        $products,
        $createInvoice = true,
        $shipped = false,
        $dataConfig
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        foreach ($products as $item) {
            $this->webposIndex->getCheckoutProductList()->search($item['product']->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutContainer()->waitForProductDetailPopup();
            // Choose first product
            sleep(4);
            $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($item['product']->getBundleSelections()['products'][0][0]->getName())->click();
            sleep(1);
            $this->webposIndex->getCheckoutProductDetail()->getProductQtyInput()->setValue($item['orderQty']);
            $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
        }

        // change customer
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        //Config payment method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfig]
        )->run();
        $k = 0;
        while (!$this->webposIndex->getCheckoutProductDetail()->isVisible() && $k < 5) {
            sleep(1);
            $k++;
        }
        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()) {
            $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($item['product']->getBundleSelections()['products'][0][0]->getName())->click();
            sleep(1);
            $this->webposIndex->getCheckoutProductDetail()->getProductQtyInput()->setValue($item['orderQty']);
            $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
        }

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()) {
            // Choose first product
            sleep(4);
            $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($item['product']->getBundleSelections()['products'][0][0]->getName())->click();
            sleep(1);
            $this->webposIndex->getCheckoutProductDetail()->getProductQtyInput()->setValue($item['orderQty']);
            $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
        }
        $this->webposIndex->getCheckoutPaymentMethod()->getCashOnDeliveryMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();

        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()) {
            // Choose first product
            sleep(4);
            $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($item['product']->getBundleSelections()['products'][0][0]->getName())->click();
            sleep(1);
            $this->webposIndex->getCheckoutProductDetail()->getProductQtyInput()->setValue($item['orderQty']);
            $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
        }
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

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

        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        self::assertTrue(
            $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->isVisible(),
            'Payment Method didn\'t show'
        );
        $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
        $this->webposIndex->getMsWebpos()->waitForModalPopup();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();

        //Assert Tax Amount in Order History Refund
        $this->assertPaymentSuccess->processAssert($this->webposIndex);

        // Invoice
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateInvoiceInOrderHistoryStep',
            ['products' => $products]
        )->run();

        // Assert Invoice Success
        $this->assertInvoiceSuccess->processAssert($this->webposIndex);
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForProcessingStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Processing');

        // Shipment
        if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        }
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Ship')->click();
        $this->webposIndex->getOrderHistoryContainer()->waitForShipmentPopupIsVisible();
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        $this->webposIndex->getMsWebpos()->waitForModalPopup();
        sleep(2);
        $this->webposIndex->getModal()->getOkButton()->click();

        // Assert Shipment Success
        $this->assertShipmentSuccess->processAssert($this->webposIndex);
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForCompleteStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Complete');


        // Refund
        if (!$this->webposIndex->getOrderHistoryRefund()->isVisible()) {
            if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
                $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            }
            sleep(1);
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
            sleep(2);
        }
        $this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();
        if (isset($item['refundQty'])) {
            $this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($products[0]['product']->getBundleSelections()['products'][0][0]->getName())->setValue($item['refundQty']);
        }
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        sleep(2);
        $this->webposIndex->getMsWebpos()->waitForModalPopup();
        $this->webposIndex->getModal()->getOkButton()->click();

        // Assert Refund Success
        $this->assertRefundSuccess->processAssert($this->webposIndex, 'Closed');
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForClosedStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Closed');


        return [
            'products' => $products
        ];
    }
}