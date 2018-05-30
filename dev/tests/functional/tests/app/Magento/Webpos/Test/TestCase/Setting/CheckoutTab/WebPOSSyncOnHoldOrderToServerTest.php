<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/02/2018
 * Time: 08:33
 */

namespace Magento\Webpos\Test\TestCase\Setting\CheckoutTab;

use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSSyncOnHoldOrderToServerTest
 * @package Magento\Webpos\Test\TestCase\Setting\CheckoutTab
 */
class WebPOSSyncOnHoldOrderToServerTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    protected $testCaseId;

    /**
     * @var OrderIndex $orderIndex
     */
    protected $orderIndex;

    protected $menuItem;
    protected $optionNo;
    protected $successMessage;

    /**
     * @param WebposIndex $webposIndex
     * @param OrderIndex $orderIndex
     */
    public function __inject(
        WebposIndex $webposIndex,
        OrderIndex $orderIndex
    )
    {
        $this->webposIndex = $webposIndex;
        $this->orderIndex = $orderIndex;
    }

    /**
     * @param $menuItem
     * @param $optionYes
     * @param $successMessage
     * @param $productName
     * @param $optionNo
     * @param $testCaseID
     */
    public function test($menuItem, $optionYes, $successMessage, $productName, $optionNo, $testCaseID)
    {
        //set Value for tearDown function
        $this->menuItem = $menuItem;
        $this->optionNo = $optionNo;
        $this->successMessage = $successMessage;

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->general();
        sleep(1);
        $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
        sleep(1);
        if ($testCaseID == 'SET17' || $testCaseID == 'SET18') {
            $this->webposIndex->getGeneralSettingContentRight()->selectSyncOnHoldOrderOption($optionYes);
        } elseif ($testCaseID == 'SET19') {
            $this->webposIndex->getGeneralSettingContentRight()->selectSyncOnHoldOrderOption($optionYes);
            $this->webposIndex->getGeneralSettingContentRight()->selectSyncOnHoldOrderOption($optionNo);
        }

        sleep(0.5);
        self::assertEquals(
            $successMessage,
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'On the Account Setting General Page - We could not save the Sync Hold Order Option. Please check again.'
        );
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($productName);
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Get hold order ID
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $orderID = $this->webposIndex->getOnHoldOrderOrderList()->getIdFirstOrder();
        if ($testCaseID == 'SET18') {
            $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
            $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
            //PlaceOrder
            $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
            sleep(1);
            $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            sleep(1);
        }
        //Open Sales -> Order
        $this->orderIndex->open();
        $this->orderIndex->getSalesOrderGrid()->search(['id' => $orderID]);
        if ($testCaseID == 'SET17' || $testCaseID == 'SET18') {
            $backEndOrderId = $this->orderIndex->getSalesOrderGrid()->getFirstItemId();
            self::assertGreaterThan(
                0,
                $backEndOrderId,
                'We could not save the on hold order ID from WebPOS to order list backend page.'
            );
        }
        $this->testCaseId = $testCaseID;
    }

    public function tearDown()
    {
        if ($this->testCaseId == 'SET17' || $this->testCaseId == 'SET18') {
            // LoginTest webpos
            $staff = $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\LoginWebposStep'
            )->run();

            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();

            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->general();
            sleep(1);
            $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($this->menuItem)->click();
            sleep(1);
            $this->webposIndex->getGeneralSettingContentRight()->selectSyncOnHoldOrderOption($this->optionNo);
            sleep(1);
            self::assertEquals(
                $this->successMessage,
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'On the Account Setting General Page - We could not save the Sync Hold Order Option. Please check again.'
            );
        }
    }
}