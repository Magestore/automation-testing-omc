<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
class WebposManageStaffMS59Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
    }

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    ) {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, $products)
    {
        //Create role and staff for role
        $webposRole->persist();
        $dataStaff = $webposRole->getDataFieldConfig('staff_id')['source']->getStaffs()[0]->getData();

        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];

        //Login
        $this->loginWebpos($this->webposIndex, $dataStaff['username'],$dataStaff['password']);

        //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Checkout
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);
        //Get orderId
        $orderId1 = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId1= ltrim ($orderId1,'#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        sleep(1);
        //Take payment
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->search($orderId1);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        sleep(1);
        if($this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->isVisible())
            $this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
        while(!$this->webposIndex->getModal()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getModal()->getOkButton()->click();

        //Check take payment successfully

        //Create Shipping
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddOrderNote()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();
        while(!$this->webposIndex->getOrderHistoryShipment()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        $this->webposIndex->getModal()->getOkButton()->click();

        //Check shipment successfully

        //Create invoice a partial
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        while(!$this->webposIndex->getOrderHistoryInvoice()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        while(!$this->webposIndex->getModal()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getModal()->getOkButton()->click();
        //Check create invoice successfully

        //Create refund product



        //Create cancel
            //Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
            //Checkout
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
            //PlaceOrder
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);
            //Get orderId
        $orderId2 = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId2= ltrim ($orderId2,'#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        sleep(1);
            //Take payment
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->search($orderId2);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        sleep(1);
        if($this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->isVisible())
            $this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
        while(!$this->webposIndex->getModal()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getModal()->getOkButton()->click();
        //Create Shipping
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddOrderNote()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddOrderNote()->getShipButton()->click();
        while(!$this->webposIndex->getOrderHistoryShipment()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();
        while(!$this->webposIndex->getModal()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getModal()->getOkButton()->click();
            //Create invoice a partial
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        while(!$this->webposIndex->getOrderHistoryInvoice()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryInvoice()->getItemQtyToInvoiceInput($product1->getName())->setValue(0);
        $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        while(!$this->webposIndex->getModal()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getModal()->getOkButton()->click();
        //Create cancel
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddOrderNote()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddOrderNote()->getCancelButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddCancelComment()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddCancelComment()->getSaveButton()->click();
        while(!$this->webposIndex->getModal()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getModal()->getOkButton()->click();

    }

    public function loginWebpos(WebposIndex $webposIndex, $username, $password)
    {
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible()) {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $webposIndex->getLoginForm()->clickLoginButton();
            $webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader');
            $webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $webposIndex->getLoginForm()->setLocation('Store Address');
            $webposIndex->getLoginForm()->setPos('Store POS');
            $webposIndex->getLoginForm()->getEnterToPos()->click();
            //			$this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        if($this->webposIndex->getOpenSessionPopup()->isOpenSessionDisplay())
        {
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
        }
    }
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

