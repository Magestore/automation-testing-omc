<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 08:17
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionCancel;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOHMassActionCancelTest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionCancel
 * OH45 & OH46 & OH47 & OH48 & OH49 & OH50 & OH51 & OH53:
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create a pending order
 * OH45
 * Steps:
 * 1. Go to order details page
 * 2. Click on icon on the top of the right
 * 3. Click on Cancel action
 * Acceptance Criteria:
 * Display Cancel Comment popup includding:
 * - buttons: Cancel, save
 * - Textarea to enter comment
 *
 * OH46
 * Steps:
 * 1. Go to order details page
 * 2. Click to Cancel order
 * 3. Click to Cancel on Comment popup
 * Acceptance Criteria:
 * 1. Close comment popup
 * 2. Order status is changeless
 *
 * OH48
 * Steps:
 * 1. Go to order details page
 * 2. Click to Cancel order
 * 3. Save Comment
 * 4. Close confirmation popup
 * Acceptance Criteria:
 * Close confirmation popup
 *
 * OH49
 * Steps:
 * 1. Go to order details page
 * 2. Click to Cancel order
 * 3. Save Comment
 * 4. Cancel confirmation popup
 * Acceptance Criteria:
 * Close confirmation popup
 *
 * OH50
 * Steps:
 * 1. Go to order details page
 * 2. Click to Cancel order
 * 3. Enter comment
 * 4. Save Comment> OK confirmation
 * Acceptance Criteria:
 * 1. Close popup
 * 2. Order status will be changed to Cancelled
 * 3. Hide actions Send email, ship, cancel, refund on Action box
 * 4. Hide Take payment, Invoice buttons on order detail page
 * 5. Order in backend will be updated too
 * 6. A new notification will be display on notification icon
 *
 * OH51
 * Steps:
 * 1. Create shipment
 * 2. Click to Cancel order
 * 3. Enter comment
 * 4. Save Comment> OK confirmation
 * Acceptance Criteria:
 * 1. Close popup
 * 2. Order was cancelled successfully
 * 3. A new notification will be display on notification icon
 *
 * OH53
 * Steps:
 * 1. Go to order details page
 * 2. Cancel that order
 * Acceptance Criteria:
 * 1. Order was cancelled successfully
 * 2. A new notification will be display on notification icon
 */
class WebposOHMassActionCancelTest extends Injectable
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
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @var AssertShipmentSuccess $assertShipmentSuccess
     */
    protected $assertShipmentSuccess;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @param AssertShipmentSuccess $assertShipmentSuccess
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertShipmentSuccess $assertShipmentSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertShipmentSuccess = $assertShipmentSuccess;
    }

    /**
     * @param bool $createOrderInBackend
     * @param OrderInjectable|null $order
     * @param null $products
     * @param bool $addCustomSale
     * @param null $customProduct
     * @param bool $createInvoice
     * @param bool $shipped
     * @param bool $createShipment
     * @param null $comment
     * @param string $action
     * @param string $confirmAction
     * @return array
     */
    public function test(
        $createOrderInBackend = false,
        OrderInjectable $order = null,
        $products = null,
        $addCustomSale = false,
        $customProduct = null,
        $createInvoice = true,
        $shipped = false,
        $createShipment = false,
        $comment = null,
        $action = 'save',
        $confirmAction = 'ok'
    )
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        if ($createOrderInBackend) {
            $order->persist();
            $orderId = $order->getId();
        } else {
            if ($addCustomSale) {
                $this->objectManager->getInstance()->create(
                    'Magento\Webpos\Test\TestStep\AddCustomSaleStep',
                    ['customProduct' => $customProduct]
                )->run();
            } else {
                // Create products
                $products = $this->objectManager->getInstance()->create(
                    'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
                    ['products' => $products]
                )->run();

                // Add product to cart
                $this->objectManager->getInstance()->create(
                    'Magento\Webpos\Test\TestStep\AddProductToCartStep',
                    ['products' => $products]
                )->run();
            }
            // Place Order
            $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
            for ($i = 0; $i < 2; $i++) {
                $this->webposIndex->getMsWebpos()->waitCartLoader();
                $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
            }
            $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
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

            //Assert Place Order Success
            $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

            $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());

            $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
        }
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        //select the first order
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
        // Create Shipment
        if ($createShipment) {
            $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\CreateShipmentInOrderHistoryStep',
                [
                    'products' => $products
                ]
            )->run();
            $this->assertShipmentSuccess->processAssert($this->webposIndex);
        }
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CancelOrderStep',
            [
                'comment' => $comment,
                'action' => $action,
                'confirmAction' => $confirmAction
            ]
        )->run();
        return [
            'products' => $products,
            'orderId' => $orderId
        ];
    }
}