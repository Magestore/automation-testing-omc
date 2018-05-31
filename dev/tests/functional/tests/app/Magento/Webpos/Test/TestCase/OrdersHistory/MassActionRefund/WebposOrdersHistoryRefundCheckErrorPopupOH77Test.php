<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/1/2018
 * Time: 8:05 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\AssertOrderStatus;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryRefundCheckErrorPopupOH77Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order with completed status and shipping fee > 0
 * Steps:
 * 1. Click to refund order and input valid values into fields to meet condition:
 * SUM(rowtotal) + Refund shipping + adjust refund - adjust fee < Total paid
 * 2. Submit > Ok confirmation > OK
 * Acceptance Criteria:
 * Close error popup
 */
class WebposOrdersHistoryRefundCheckErrorPopupOH77Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertRefundSuccess $assertRefundSuccess
     */
    protected $assertRefundSuccess;

    /**
     * @var AssertOrderStatus $assertOrderStatus
     */
    protected $assertOrderStatus;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertRefundSuccess $assertRefundSuccess
     * @param AssertOrderStatus $assertOrderStatus
     */
    public function __inject(WebposIndex $webposIndex, AssertRefundSuccess $assertRefundSuccess, AssertOrderStatus $assertOrderStatus)
    {
        $this->webposIndex = $webposIndex;
        $this->assertRefundSuccess = $assertRefundSuccess;
        $this->assertOrderStatus = $assertOrderStatus;
    }

    /**
     * @param $products
     * @param $refundShipping
     * @param $adjustRefund
     * @param $adjustFee
     * @return array
     */
    public function test($products, $refundShipping, $adjustRefund, $adjustFee)
    {
        // Config all allow shipping for pos
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'all_allow_shipping_for_POS']
        )->run();
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
        // Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Select flat rate shipping method
        $this->webposIndex->getCheckoutShippingMethod()->clickFlatRateFixedMethod();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $shippingFee = (float)substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Shipping')->getText(), 1);
        // Select payment
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => true,
                'shipped' => true
            ]
        )->run();
        // Place Order
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        // Open refund popup
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->click();
        sleep(1);
        // Refund
        if (!isset($refundShipping)) {
            $refundShipping = $shippingFee;
        }
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
            ['products' => $products, 'refundShipping' => $refundShipping, 'adjustRefund' => $adjustRefund, 'adjustFee' => $adjustFee]
        )->run();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->isVisible(),
            'Error popup is not close.'
        );
        return [
            'products' => $products,
            'refundShipping' => $refundShipping,
        ];
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'all_allow_shipping_for_POS_rollback']
        )->run();
    }
}