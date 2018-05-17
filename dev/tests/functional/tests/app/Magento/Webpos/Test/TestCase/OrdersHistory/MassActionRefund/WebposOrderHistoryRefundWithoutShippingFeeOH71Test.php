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
 * Class WebposOrderHistoryRefundWithoutShippingFeeOH71Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 */
class WebposOrderHistoryRefundWithoutShippingFeeOH71Test extends Injectable
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
        $shippingFee = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Shipping')->getText(), 1);
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
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        // Open refund popup
        sleep(0.5);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        sleep(0.5);
        $this->webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->click();
        sleep(1);
        // Refund
        $refundShipping = 0;
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
            ['products' => $products, 'adjustRefund' => 0, 'adjustFee' => 0, 'refundShipping' => $refundShipping]
        )->run();

        return ['products' => $products, 'refundShipping' => $refundShipping];
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'all_allow_shipping_for_POS_rollback']
        )->run();
    }
}