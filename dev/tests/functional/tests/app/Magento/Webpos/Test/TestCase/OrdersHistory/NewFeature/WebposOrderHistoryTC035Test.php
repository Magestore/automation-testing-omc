<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/35
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\NewFeature;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Show child-product of bundle product  in order detail
 * Testcase - Check showing qty of each child item on product detail page after placing order with the various qty for each child item
 *
 * Precondition
 * - Empty
 *
 * Steps
 * 1. Add bundle product to cart with various qty for each child item
 * 2. Checkout order
 * 3. View the order just created
 * 4. Observe the qty of each child items on order detail page and on the order receipt
 *
 * Acceptance
 * 4. Show the correct qty for each child items
 *
 * Class WebposManageSessionTC035
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposOrderHistoryTC035Test extends Injectable
{
    //Open session
    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();
    }

    /**
     * @param WebposIndex $webposIndex
     * @param $products
     * @param $qty
     */

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
        $webposIndex->getCheckoutProductDetail()->waitForFormLoader();
        $webposIndex->getCheckoutProductDetail()->selectBundleProductFirstItemWithRadio();
//        $webposIndex->getCheckoutProductDetail()->setQtyBundleChildProduct);
        $webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $webposIndex->getCheckoutProductDetail()->waitForElementNotVisible('#popup-product-detail');
        $webposIndex->getCheckoutContainer()->waitForProductInCartLoader();

        //Checkout
        $webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#webpos_checkout');
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#checkout-method .payment');
        self::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getPaymentByMethod('cashforpos')->isVisible(),
            'Payment method didn\'t show'
        );
        $webposIndex->getCheckoutPlaceOrder()->getPaymentByMethod('cashforpos')->click();
        sleep(1);
        $webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $webposIndex->getCheckoutSuccess()->waitForLoadingIndicator();
        sleep(2);
        if ($webposIndex->getCheckoutProductDetail()->isVisible()) {
            $webposIndex->getCheckoutProductDetail()->getCancelButton()->click();
        }
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
        sleep(1);
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

    }

    /*Close session*/
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }
}