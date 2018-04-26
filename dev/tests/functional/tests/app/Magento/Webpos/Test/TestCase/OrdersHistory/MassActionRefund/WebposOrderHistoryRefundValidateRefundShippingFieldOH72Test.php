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
 * Class WebposOrderHistoryRefundValidateRefundShippingFieldOH72Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 */
class WebposOrderHistoryRefundValidateRefundShippingFieldOH72Test extends Injectable
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
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();
        // Checkout
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
        sleep(0.5);
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        // Open refund popup
        sleep(0.5);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        sleep(0.5);
        $this->webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->click();
        sleep(1);
        // Refund
        $refundShipping = $shippingFee + 1;
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateRefundInOrderHistoryStep',
            ['products' => $products, 'adjustRefund' => 0, 'adjustFee' => 0, 'refundShipping' => $refundShipping]
        )->run();
        $errorMessage = 'The refundable shipping amount is limited at ' . $shippingFee;
        $actualErrorMessage = $this->webposIndex->getToaster()->getWarningMessage()->getText();
        $this->assertEquals(
            $errorMessage,
            $actualErrorMessage,
            'Error message is wrong.'
            . "\nExpected: " . $errorMessage
            . "\nActual: " . $actualErrorMessage
        );

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