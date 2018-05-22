<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 1/30/2018
 * Time: 7:57 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionShip;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryCreateShipmentOH38Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionShip
 */
class WebposOrdersHistoryCreateShipmentOH38Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products, $trackNumber, $shipmentComment)
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
        // Place Order
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $orderId = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        // Go to Order History
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        // Open shipment popup
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();
        $this->webposIndex->getOrderHistoryShipment()->getTrackNumber()->setValue($trackNumber);
        $this->webposIndex->getOrderHistoryShipment()->getShipmentComment()->setValue($shipmentComment);
        $this->webposIndex->getOrderHistoryShipment()->getSendMailCheckbox()->click();
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        $this->webposIndex->getModal()->waitForOkButtonIsVisible();
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        return [
            'products' => $products,
            'status' => 'Complete',
            'orderId' => $orderId
        ];
    }
}