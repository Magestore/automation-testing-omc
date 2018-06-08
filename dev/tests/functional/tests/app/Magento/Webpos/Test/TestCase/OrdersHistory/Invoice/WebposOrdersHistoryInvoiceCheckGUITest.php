<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/31/2018
 * Time: 9:42 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\Invoice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI\AssertWebposOrdersHistoryInvoice;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryInvoiceCheckGUITest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\Invoice
 * Precondition and setup steps:
 * OH102 & OH103 & OH104 & OH105
 * 1. Login webpos as a staff
 * 2. Create an order
 * 3. Create payment
 * Steps:
 * OH102:
 * 1. Click to invocie order
 * 2. Cancel
 * OH103:
 * 1. Click to invocie order
 * 2. Fill Qty for each item
 * 3. Submit invoice
 * OH104 & OH105:
 * 1. Click to invocie order
 * 2. Fill Qty for each item
 * 3. Submit invoice > Cancel confirmation
 * Acceptance Criteria:
 * OH102:
 * Close Invoice popup
 * OH103:
 * Display confirmation popup :"Are you sure you want to submit this invoice? "  with 2 buttons: Cancel, OK and 1 action: Close
 * OH104&OH105:
 * Close confirmation popup
 */
class WebposOrdersHistoryInvoiceCheckGUITest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposOrdersHistoryInvoice $assertWebposOrdersHistoryInvoice
     */
    protected $assertWebposOrdersHistoryInvoice;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposOrdersHistoryInvoice $assertWebposOrdersHistoryInvoice
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposOrdersHistoryInvoice $assertWebposOrdersHistoryInvoice
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposOrdersHistoryInvoice = $assertWebposOrdersHistoryInvoice;
    }

    /**
     * @param $products
     * @param bool $createInvoice
     * @param bool $shipped
     * @return array
     */
    public function test(
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
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashOnDeliveryMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => $createInvoice,
                'shipped' => $shipped
            ]
        )->run();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
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
        $this->webposIndex->getMainContent()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);

        // Take payment
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->isVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        if ($this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->isVisible()) {
            $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod('Web POS - Cash In')->click();
            $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
            $this->webposIndex->getMsWebpos()->waitForModalPopup();
            $this->webposIndex->getModal()->getOkButton()->click();

            // Click Button Invoice
            $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
            $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();

            $action = 'CheckGUI';
            $this->assertWebposOrdersHistoryInvoice->processAssert($this->webposIndex, $action);

            sleep(2);
            $action = 'Popup-CheckGUI';
            $this->assertWebposOrdersHistoryInvoice->processAssert($this->webposIndex, $action);

            sleep(2);
            $action = 'Popup-Cancel';
            $this->assertWebposOrdersHistoryInvoice->processAssert($this->webposIndex, $action);

            sleep(2);
            $action = 'Popup-Close';
            $this->assertWebposOrdersHistoryInvoice->processAssert($this->webposIndex, $action);

            sleep(2);
            $action = 'Cancel';
            $this->assertWebposOrdersHistoryInvoice->processAssert($this->webposIndex, $action);

            return [
                'products' => $products,
                'action' => $action
            ];
        }
    }
}