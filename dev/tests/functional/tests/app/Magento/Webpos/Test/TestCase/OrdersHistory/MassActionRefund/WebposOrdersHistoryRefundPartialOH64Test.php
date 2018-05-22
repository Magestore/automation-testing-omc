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
 * Class WebposOrdersHistoryRefundPartialOH64Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 */
class WebposOrdersHistoryRefundPartialOH64Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertRefundSuccess
     */
    protected $assertRefundSuccess;

    /**
     * @var AssertOrderStatus
     */
    protected $assertOrderStatus;

    public function __inject(WebposIndex $webposIndex, AssertRefundSuccess $assertRefundSuccess, AssertOrderStatus $assertOrderStatus)
    {
        $this->webposIndex = $webposIndex;
        $this->assertRefundSuccess = $assertRefundSuccess;
        $this->assertOrderStatus = $assertOrderStatus;
    }

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
        // Create Refund Partial
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
            [
                'products' => $products
            ]
        )->run();
        // Calculate total refunded
        $shippingFee = $this->webposIndex->getOrderHistoryOrderViewFooter()->getShipping();
        $shippingFee = (float)substr($shippingFee, 1);
        $totalRefunded = 0;
        foreach ($products as $key => $item) {
            $productName = $item['product']->getName();
            $rowTotal = $this->webposIndex->getOrderHistoryOrderViewContent()->getRowTotalOfProduct($productName);
            $rowTotal = (float)substr($rowTotal, 1);
            $totalRefunded += ($rowTotal/$item['orderQty'])*$item['refundQty'];
        }
        $totalRefunded += $shippingFee;
        sleep(1);
        // Assert Refund Success
        $this->assertRefundSuccess->processAssert($this->webposIndex, $expectStatus = 'Complete', $totalRefunded);
        // Refund Extant Items
        $tempProducts = $products;
        unset($tempProducts[0]['refundQty']);
        // Refund
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
            ['products' => $tempProducts]
        )->run();
        // Assert Order Status
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForCompleteStatusVisisble();
        $this->assertOrderStatus->processAssert($this->webposIndex, 'Complete');
    }
}