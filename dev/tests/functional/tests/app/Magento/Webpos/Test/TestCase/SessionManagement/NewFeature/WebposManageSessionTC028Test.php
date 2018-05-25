<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/28
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\NewFeature;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Set order to refund to have 0 qty for all product instead of 1
 * Testcase TS028- Check the default value in Qty to refund field when making refund order which having some products
 *
 * Precondition
 * -Empty
 *
 * Steps
 * 1. Add some product to cart
 * 2. Checkout order
 * 3. After checking order, make the refund for 1 item of order
 * 4. Continue creating refund remaining items
 * 5. Observe the default value in Qty to refund field on each row
 *
 * Acceptance
 *  4. On each row, show the value default  is 0  in the Qty to refund field
 *
 *
 * Class WebposManageSessionTC028
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposManageSessionTC028Test extends Injectable
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
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#checkout-method');
        sleep(1);
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

        //Refund a item
        $webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($products[0]->getName())->setValue(1);
        $webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        $webposIndex->getModal()->waitForLoader();
        $webposIndex->getModal()->getOkButton()->click();
        $webposIndex->getToaster()->waitWarningMessageHide();

        //Show refund form  again
        $webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $webposIndex->getOrderHistoryOrderViewHeader()->waitForElementVisible('#form-add-note-order');
        $webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $webposIndex->getOrderHistoryRefund()->waitForElementVisible('#creditmemo-popup-form');

        \PHPUnit_Framework_Assert::assertEquals(
            0,
            (int)$webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($products[1]->getName())->getValue(),
            'Item quantity is incorrect'
        );
    }

}