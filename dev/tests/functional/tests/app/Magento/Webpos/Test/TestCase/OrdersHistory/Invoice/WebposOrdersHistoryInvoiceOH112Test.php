<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 2:06 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryInvoiceOH112Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create a pending order with some  products
 * 3. Create payment a partial
 * Steps:
 * Invoice all available items
 * Acceptance Criteria:
 * 1. Create Invoice successfully
 * 2. Don't allow invoice extant items
 * 3. Order status will be changed to processsing
 */
class WebposOrdersHistoryInvoiceOH112Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertInvoiceSuccess $assertInvoiceSuccess
     */
    protected $assertInvoiceSuccess;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertInvoiceSuccess $assertInvoiceSuccess
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertInvoiceSuccess $assertInvoiceSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertInvoiceSuccess = $assertInvoiceSuccess;
    }

    /**
     * @param $products
     * @param $dataConfig
     * @return array
     */
    public function test(
        $products,
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
        $this->webposIndex->getMainContent()->waitLoader();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        //Config payment method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfig]
        )->run();

        // Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMainContent()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashOnDeliveryMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => false,
                'shipped' => false
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMainContent()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Refresh Webpos
        $this->webposIndex->open();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Order history
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        // Take payment
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        $this->webposIndex->getOrderHistoryPayment()->waitForElementVisible('#payment_popup_form');
        self::assertTrue(
            $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->isVisible(),
            'Payment Method didn\'t displayed'
        );
        if ($this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->isVisible()) {
            $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->click();
            $paymentPrice = (float)substr($this->webposIndex->getOrderHistoryPayment()->getPaymentPriceInput()->getValue(), 1);
            $this->webposIndex->getOrderHistoryPayment()->getPaymentPriceInput()->setValue($paymentPrice / 2);
            $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
            $this->webposIndex->getMsWebpos()->waitForModalPopup();
            sleep(0.5);
            $this->webposIndex->getModal()->getOkButton()->click();
            // Click Button Invoice
            sleep(1);
            $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
            $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
            sleep(0.5);
            $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
            $this->webposIndex->getMsWebpos()->waitForModalPopup();
            sleep(0.5);
            $this->webposIndex->getModal()->getOkButton()->click();
            // Assert Invoice successful.
            $this->assertInvoiceSuccess->processAssert($this->webposIndex);

            $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForProcessingStatusVisisble();
        }
        return [
            'products' => $products
        ];
    }
}