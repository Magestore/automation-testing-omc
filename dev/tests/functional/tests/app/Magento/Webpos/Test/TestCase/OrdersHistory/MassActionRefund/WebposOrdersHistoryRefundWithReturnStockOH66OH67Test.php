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
 * Class WebposOrdersHistoryRefundWithReturnStockOH66OH67Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 * OH66 & OH67
 * Precondition and setup steps:
 * "1. Login webpos as a staff
 * 2. Create an order with completed status
 *
 * OH67
 * Steps:
 * 1. Click to refund order
 * 2. Tick on [return stock] checkbox
 * 3. Submit > Ok confirmation
 * 4. Go to Manage stocks menu > Check qty of the product that just refunded
 * Acceptance Criteria:
 * Manage stock page: Qty of refunded items will be updated
 *
 * OH68
 * Steps:
 * 1. Click to refund order
 * 2. Untick on [return stock] checkbox
 * 3. Submit > Ok confirmation
 * 4. Go to Manage stocks menu > Check qty of the product that just refunded
 * Acceptance Criteria:
 * Manage stock page: Qty of refunded items are changeless
 */
class WebposOrdersHistoryRefundWithReturnStockOH66OH67Test extends Injectable
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
     * @return array
     */
    public function test($products)
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
        // Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
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
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
            ['products' => $products]
        )->run();
        // Assert Refund Success
        $this->assertRefundSuccess->processAssert($this->webposIndex, 'Closed', null, 'Ship,Refund,Cancel');
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForClosedStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Closed');

        return ['products' => $products];
    }
}