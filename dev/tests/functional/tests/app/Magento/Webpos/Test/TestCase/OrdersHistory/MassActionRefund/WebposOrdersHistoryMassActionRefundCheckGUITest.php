<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 7:57 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryMassActionRefundCheckGUITest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionRefund
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order with completed status
 * and shipping fee > 0
 * Steps:
 * 1. Click to refund order
 * -  Fill available Qty
 * - Adjust refund: 0
 * - Refund shipping greater than shipping fee
 * - Adjust fee: 0
 * 2. Submit > Ok confirmation
 * Acceptance Criteria:
 * Show message: "Error: The refundable shipping amount is limited at [shipping fee]"
 */
class WebposOrdersHistoryMassActionRefundCheckGUITest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $products
     * @param null $configData
     * @return array
     */
    public function test($products, $configData = null)
    {
        // Config all allow shipping for pos
        if ($configData) {
            $this->objectManager->getInstance()->create(
                'Magento\Config\Test\TestStep\SetupConfigurationStep',
                ['configData' => $configData]
            )->run();
        }
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
        if ($configData) {
            $this->webposIndex->getCheckoutShippingMethod()->clickFlatRateFixedMethod();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }
        $shippingFee = substr($this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice('Shipping')->getText(), 1);
        // Select payment
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Place Order
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();

        $this->webposIndex->getCheckoutSuccess()->waitForLoadingIndicator();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        // Open refund popup
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryAddOrderNote()->getRefundButton()->click();
        sleep(1);
        return [
            'products' => $products,
            'shippingFee' => $shippingFee
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