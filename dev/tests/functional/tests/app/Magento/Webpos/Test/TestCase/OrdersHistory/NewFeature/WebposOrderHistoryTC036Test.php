<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/36
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\NewFeature;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Show child-product of bundle product  in order detail
 * Testcase - Check showing price of each child item on product detail page after placing order
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Add bundle product to cart
 * 2. Checkout order
 * 3. View the order just created
 * 4. Observe the price of each child items on order detail page and on the order receipt
 *
 * Acceptance
 * 4. Show the correct price for each child items
 *
 * Class WebposManageSessionTC036
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposOrderHistoryTC036Test extends Injectable
{


    public function test(WebposIndex $webposIndex, $products, $qty)
    {
        //Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        //Login
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep')->run();
        sleep(1);

        if ($webposIndex->getOpenSessionPopup()->isVisible()) {
            $webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $webposIndex->getSessionRegisterShift()->waitLoader();
        }
        if ($webposIndex->getSessionRegisterShift()->isVisible()) {
            $webposIndex->getMsWebpos()->getCMenuButton()->click();
            $webposIndex->getMsWebpos()->waitForCMenuLoader();
            $webposIndex->getCMenu()->checkout();
            $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        }

        //Add Product
        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $webposIndex->getCheckoutProductDetail()->selectBundleProductFirstItemWithRadio();
        $webposIndex->getCheckoutProductDetail()->setQtyBundleChildProduct($qty);
        $webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $webposIndex->getCheckoutProductDetail()->waitForElementNotVisible('#popup-product-detail');
        $webposIndex->getCheckoutContainer()->waitForProductInCartLoader();

        //Checkout
        $webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#webpos_checkout');
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#checkout-method');
        sleep(1);
        $webposIndex->getCheckoutPlaceOrder()->getPaymentByMethod('cashforpos')->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#payment-method');
        $webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $webposIndex->getCheckoutSuccess()->waitForLoadingIndicator();
        $webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $webposIndex->getMsWebpos()->waitForCMenuVisible();

        //Order History
        $webposIndex->getMsWebpos()->getCMenuButton()->click();
        $webposIndex->getMsWebpos()->waitForCMenuLoader();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getOrderHistoryOrderList()->waitForElementNotVisible('.loader');
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->waitListOrders();
        $webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

    }

}