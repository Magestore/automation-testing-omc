<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/24/2018
 * Time: 2:08 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOrdersHistoryMassActionShipCheckGUITest
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\CheckGUI
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order with some product
 * - Mark as shipped: off
 * Steps:
 * 1. Go to order details page
 * 2. Click on icon on the top of the right
 * 3. Click on Ship action
 * Acceptance Criteria:
 * Display Shipment popup includding:
 * - buttons: Cancel, Submit shipment
 * - items table with corresponding Qty
 * - Textbox : Track number
 * - Textarea: Shipment comment
 * - Checkbox: Send email
 */
class WebposOrdersHistoryMassActionShipCheckGUITest extends Injectable
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
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        // Open shipment popup
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();

        return ['products' => $products];
    }
}
