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
 * Class WebposOrdersHistoryShipmentWithExtantItemsOH41OH42Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionShip
 * OH41
 * Precondition and setup steps:
 * 1.  Login webpos as a staff
 * 2. Create an order with some products
 * - Mark as shipped: off
 * 3. Ship a partial (ship some items of order)
 * Steps:
 * Ship extant items of order
 * Acceptance Criteria:
 * 1. Close shipment popup and a shipment has created with corresponding item and Qty
 * 2. Ship action hidden on action box
 * 3. A new notification will be display on notification icon
 *
 * OH42
 * Precondition and setup steps:
 * 1.  Login webpos as a staff
 * 2. Create an order with one product and Qty > 1
 * - Mark as shipped: off
 * 3. Ship a partial of order (Qty shipped =1)
 * Steps:
 * Ship extant items of order
 * Acceptance Criteria:
 * 1. Close shipment popup and a shipment has created with corresponding item and Qty
 * 2. Ship action hidden on action box
 * 3. A new notification will be display on notification icon
 */
class WebposOrdersHistoryShipmentWithExtantItemsOH41OH42Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
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
        // Open shipment popup
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();
        // Create partial shipment
        foreach ($products as $item) {
            $productName = $item['product']->getName();
            $qtyToShip = $item['qtyToShip'];
            $this->webposIndex->getOrderHistoryShipment()->getQtyToShipInput($productName)->setValue($qtyToShip);
        }
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        $this->webposIndex->getModal()->waitForOkButtonIsVisible();
        $this->webposIndex->getModal()->getOkButton()->click();
        while ($this->webposIndex->getToaster()->isVisible()) {
        };
        sleep(1);
        // Create shipment with extant items
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        $this->webposIndex->getModal()->waitForOkButtonIsVisible();
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        return [
            'products' => $products,
        ];
    }
}