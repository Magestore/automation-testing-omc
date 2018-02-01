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

class WebposOrdersHistoryShipmentWithCustomProductOH43Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($customProduct)
    {
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        // Add custom product to cart
        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $random = mt_rand(1, 999999);
        $customProduct['name'] = str_replace('%isolation%', $random, $customProduct['name']);
        $customProduct['description'] = str_replace('%isolation%', $random, $customProduct['description']);
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($customProduct['name']);
        $this->webposIndex->getCheckoutCustomSale()->getDescriptionInput()->setValue($customProduct['description']);
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($customProduct['price']);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        // Checkout
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
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->assertFalse(
            $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->isVisible(),
            'Action ship is visible.'
        );
    }
}