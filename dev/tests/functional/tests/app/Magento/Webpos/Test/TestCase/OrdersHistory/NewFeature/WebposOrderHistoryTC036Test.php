<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/36
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\NewFeature;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Show child-product of bundle product  in order detail
 * Testcase: Testcase36: Check showing price of each child item on product detail page after placing order
 *           Testcase37: Check showing price if the child item of bundle product have special price
 * Precondition
 * TS37:Set the child items of bundle product having special price
 *
 * Steps
 * 1. Add bundle product to cart
 * 2. Checkout order
 * 3. View the order just created
 * 4. Observe the price of each child items on order detail page and on the order receipt
 *
 * Acceptance
 * TC036 - 4. Show the correct price for each child items
 * TC037 - 4. On order detail and on the order receipt, observe the price of child items which have special price
 *
 * Class WebposManageSessionTC036
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposOrderHistoryTC036Test extends Injectable
{
    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param bool $specialPrice
     * @return array
     */
    public function test(WebposIndex $webposIndex, $products, $specialPrice = false)
    {
        //Create products
        $bundleProduct = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        );
        $products = $bundleProduct->run();
        $childProducts = $bundleProduct->getChildProducts();
        $childProductData = array();

        foreach ($childProducts as $childProduct) {
            foreach ($childProduct as $item) {
                $childProductData[] = [
                    'name' => $item->getName(),
                    'price' => $specialPrice ? $item->getSpecialPrice() : $item->getPrice()
                ];
            }
        }

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
        sleep(2);
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        return [
            'childProducts' => [
                $childProductData[0]
            ]
        ];
    }

}