<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/30/2018
 * Time: 9:34 AM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\TakePayment;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposTakePaymentOH97Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\TakePayment
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order:
 * Select payment method: fill amount less than total
 *
 * Steps:
 * 1. Go to order details page
 * 2. Take payment
 * 3. Select a payment method  > fill amount greater than remain amount > Submit > OK
 *
 * Acceptance Criteria:
 * 1. Close Take payment popup
 * 2. Show message ""Success: Create payment successfully!""
 * 3. [Total paid] = amount that filled on step 3 of [Steps] column
 * 4. [Take payment] button will be hidden
 * 5. [Change] will be shown under [Total paid] field with amount = [filled amount] - [remain amount]
 * 6. Order status is changeless
 */
class WebposTakePaymentOH97Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * Precondition
     */
    public function __prepare()
    {
        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method_all_method']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'all_allow_shipping_for_POS']
        )->run();
    }

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param $products
     * @param FixtureFactory $fixtureFactory
     * @param $configData
     * @param $amount
     * @return array
     */
    public function test($products, FixtureFactory $fixtureFactory, $configData, $amount)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
        }

        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //select shipping
        $this->webposIndex->getCheckoutShippingMethod()->clickFlatRateFixedMethod();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //select payment
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);

        // place order getCreateInvoiceCheckbox
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //select order
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();

        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        //click take payment
        sleep(0.5);
        $am = $this->webposIndex->getOrderHistoryOrderViewHeader()->getOriginTotal();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        sleep(0.5);
        self::assertTrue(
            $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod("Web POS - Cash In")->isVi(),
            'Payment method didn\'t show'
        );

        $remain = $this->webposIndex->getOrderHistoryPayment()->getRemainMoney()->getText();
        $this->webposIndex->getOrderHistoryPayment()->getPaymentMethod("Web POS - Cash In")->click();
        sleep(1);
        sleep(0.5);
        $this->webposIndex->getOrderHistoryPayment()->getInputAmount()->setValue(substr($am, 1));
        sleep(1);

        $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();

        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        return [
            'am' => $am,
            'remain' => $remain
        ];
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'all_allow_shipping_for_POS_rollback']
        )->run();
    }
}