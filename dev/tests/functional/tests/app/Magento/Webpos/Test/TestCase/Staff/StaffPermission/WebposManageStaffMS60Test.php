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
use Magento\Webpos\Test\Constraint\Staff\AssertShowMessageNotification;
use Magento\Webpos\Test\Constraint\Staff\AssertShowNewNotification;

class WebposManageStaffMS60Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;
    /**
     * @var AssertShowMessageNotification
     */
    protected $assertShowMessageNotification;
    /**
     * @var AssertShowNewNotification
     */
    protected $assertShowNewNotification;
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
        WebposIndex $webposIndex,
        AssertShowMessageNotification $assertShowMessageNotification,
        AssertShowNewNotification $assertShowNewNotification
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertShowMessageNotification = $assertShowMessageNotification;
        $this->assertShowNewNotification = $assertShowNewNotification;
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

        //Create order
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
        $orderId1 = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();
        $orderId1= ltrim ($orderId1,'#');
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        sleep(4);

        //Go order history
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->search($orderId1);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();

        $this->webposIndex->getNotification()->getNotificationBell()->click();
        $this->webposIndex->getNotification()->getClearAll()->click();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        //Send email
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddOrderNote()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddOrderNote()->getSendMailButton()->click();
        while(!$this->webposIndex->getOrderHistorySendEmail()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistorySendEmail()->getInputSendEmail()->setValue('test@gmail.com');
        $this->webposIndex->getOrderHistorySendEmail()->getSendButton()->click();
        $this->assertShowMessageNotification->processAssert($this->webposIndex, 'An email has been sent for this order!');
        $this->webposIndex->getNotification()->getNotificationBell()->click();
        $textNotif = $this->webposIndex->getNotification()->getFirstNotificationText();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        $this->assertShowNewNotification->processAssert($this->webposIndex, 'An email has been sent for this order!', $textNotif);

        $this->webposIndex->getNotification()->getNotificationBell()->click();
        $this->webposIndex->getNotification()->getClearAll()->click();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        //Add comment
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddOrderNote()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddOrderNote()->getAddCommentButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddComment()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddComment()->getInputComment()->setValue('test add comment');
        $this->webposIndex->getOrderHistoryAddComment()->getSaveButton()->click();
        $this->assertShowMessageNotification->processAssert($this->webposIndex, 'Add order comment successfully!');
        $this->webposIndex->getNotification()->getNotificationBell()->click();
        $textNotif = $this->webposIndex->getNotification()->getFirstNotificationText();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        $this->assertShowNewNotification->processAssert($this->webposIndex, 'Add order comment successfully!', $textNotif);

        //Re-order
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        while(!$this->webposIndex->getOrderHistoryAddOrderNote()->isVisible())
        {
            sleep(1);
        }
        $this->webposIndex->getOrderHistoryAddOrderNote()->getReOrderButton()->click();
        sleep(3);

        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = 1;
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = 1;
        return ['cartProducts' => [$dataProduct1, $dataProduct2]];
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
