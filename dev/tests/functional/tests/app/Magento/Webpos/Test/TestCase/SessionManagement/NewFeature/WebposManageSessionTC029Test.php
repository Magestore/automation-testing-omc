<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/29
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\NewFeature;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - make return to stock always selected (Khi refund thì sản phẩm luôn được back lại in stock
 * Testcase TS029 - Observe the return to stock checkbox when making refund order which having a product
 *          TS029 - Observe the return to stock checkbox when making refund order which having some products
 *
 * Precondition
 * -Empty
 *
 * Steps
 * 1. Add a product to cart
 * 2. Checkout order
 * 3. After checking order completely , make the refund for order
 * 4. Observe the  Return to stock checkbox
 *
 * Acceptance
 *  TC029 the Return to stock checkbox  is auto checked
 *  TC030 On each row, the Return to stock checkbox  is auto checked
 *
 *
 * Class WebposManageSessionTC029
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposManageSessionTC029Test extends Injectable
{

    public function __inject()
    {
        //Preconditon
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no,config_no_send_confirm_order']
        )->run();

    }

    public function test(FixtureFactory $fixtureFactory, WebposIndex $webposIndex, $products)
    {
        //Login
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep')->run();
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
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
            $i++;
        }

        //Check out with payment
        $webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#webpos_checkout');
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#checkout-method .payment');
        $webposIndex->getCheckoutPlaceOrder()->getPaymentByMethod('cashforpos')->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#payment-method');
        $webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $webposIndex->getCheckoutSuccess()->waitForLoadingIndicator();
        $webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $webposIndex->getMsWebpos()->waitForCMenuVisible();

        //Show refund order
        $webposIndex->getMsWebpos()->getCMenuButton()->click();
        $webposIndex->getMsWebpos()->waitForCMenuLoader();
        $webposIndex->getCMenu()->ordersHistory();
        $webposIndex->getOrderHistoryOrderList()->waitForElementNotVisible('.loader');
        $webposIndex->getOrderHistoryOrderList()->waitLoader();
        $webposIndex->getOrderHistoryOrderList()->waitListOrders();
        $webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        sleep(1);
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $webposIndex->getOrderHistoryOrderViewHeader()->waitForElementVisible('#form-add-note-order');
        $webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $webposIndex->getOrderHistoryRefund()->waitForElementVisible('#creditmemo-popup-form');

        foreach ($products as $product){
            \PHPUnit_Framework_Assert::assertEquals(
                1,
                (int)$webposIndex->getOrderHistoryRefund()->getItemReturnToStockCheckbox($product->getName())->getValue(),
                'Return checkbox wasn\'t checked'
            );
        }
    }

}