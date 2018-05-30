<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/33
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\NewFeature;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Show child-product of bundle product  in order detail
 * Testcase - Check showing bundle product on the order detail page after checking out order which having bundle product
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Add bunble product to cart
 * 2. Checkout order
 * 3. Go to order history, view detail order just created
 *
 * Acceptance
 * 3. On order detail page, show all child product of bunble product with the following information: name of product, sku, price, qty, subtotal, Tax amount, discount amount, row total
 *
 * Class WebposManageSessionTC033
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposOrderHistoryTC033Test extends Injectable
{
    /**
     * @param FixtureFactory $fixtureFactory
     * @param WebposIndex $webposIndex
     * @param $products
     */
    public function test(FixtureFactory $fixtureFactory, WebposIndex $webposIndex, $products)
    {
        // Create products
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