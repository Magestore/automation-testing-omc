<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportZR010Test
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = "Yes" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session with
 * - Opening amount: >0
 * - Take money in: >0
 * - Take money out:  >0
 * 3. Create some orders successfully meet conditions:
 * - Using some payment methods (including cashin method)
 * - Apply discount whole cart
 * 4. Refund an order that placed on this session
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully with:
 * - Close amount: Input a number that greater than 0 and different from [Theoretical Closing Amount]
 * 3. Click to print Z-report
 *
 * Acceptance:
 * 3. Show Z-report with:
 * - [Opening Amount] is the inputed open amount on step 2  of [Precondition and setup steps] column
 * - [Closing Amount] is the inputed closing amount on step 2 of [Steps] column
 * - Theoretical Closing Amount = Cash Sales - Cash refund - Payouts + Pay Ins + Opening amount
 * - Difference = [Closing Amount] - [Theoretical Closing Amount]
 *
 * - Cash sales = The total cash sales processed including discounts and tax on this session
 * - Cash Refund = Refund amount by cashin
 * - [Pay Ins] = SUM(amount of Put_money_in)
 * - Payouts = SUM(amount of Take_money_out)
 *
 * - Total Sales = SUM(grand_total) of the orders which placed on this session
 * - Discount = SUM (discount_amount) of the orders which placed on this session
 * - Refund = SUM (refunded_amount) on this session
 * - Net Sales = [Total Sales] - [Refund]
 *
 * - cashforpos = [Cash sales]
 * And show all of the payment methods with their total that placed on this session
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposZreportZR010Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    protected $dataConfigToNo;

    protected $defaultPaymentMethod;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;


    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test($products, Denomination $denomination,
                         $denominationNumberCoin,
                         ConfigData $dataConfig, ConfigData $dataConfigToNo,
                         $dataConfigPayment,
                         $defaultPaymentMethod, $amount,
                         $putMoneyInValue, $takeMoneyOutValue,
                         $addDiscount = false,
                         $discountAmount = '')
    {
        // Create denomination
        $denomination->persist();
//        $this->dataConfigToNo = $dataConfigToNo;
//        $this->objectManager->create(
//            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
//            ['dataConfig' => $dataConfig]
//        )->run();

        //Config Customer Credit Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfigPayment]
        )->run();

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep',
            [
                'openingAmountStatus' => true,
                'denomination' => $denomination,
                'denominationNumberCoin' => $denominationNumberCoin,
                'putMoneyInStatus' => true,
                'putMoneyInValue' => $putMoneyInValue,
                'takeMoneyOutStatus' => true,
                'takeMoneyOutValue' => $takeMoneyOutValue
            ]
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
        }

        if ($addDiscount) {
            $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\AddDiscountWholeCartStep',
                [
                    'percent' => $discountAmount,
                    'type' => '$'
                ]
            )->run();
        }

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#add-more-payment');
        $this->webposIndex->getCheckoutAddMorePayment()->getCashIn()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Refund
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        sleep(0.5);

        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(0.5);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForFormAddNoteOrderVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        $this->webposIndex->getMsWebpos()->waitForModalPopup();
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForModalPopupNotVisible();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        // Set closing balance
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        $this->webposIndex->getSessionCloseShift()->waitSetClosingBalancePopupVisible();
        $this->webposIndex->getSessionSetClosingBalancePopup()->setCoinBillValue($denomination->getDenominationName());
        $this->webposIndex->getSessionSetClosingBalancePopup()->getColumnNumberOfCoinsAtRow(2)->setValue($denominationNumberCoin);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionCloseShift()->waitSetClosingBalancePopupNotVisible();
        if ($this->webposIndex->getSessionConfirmModalPopup()->isVisible()) {
            $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
            $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupVisible();
            $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
            $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
            $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupNotVisible();
        }
        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);

        $cashSales = $this->webposIndex->getSessionShift()->getPaymentAmount(1)->getText();
        $otherPaymentSales = $this->webposIndex->getSessionShift()->getPaymentAmount(2)->getText();

        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitZreportVisible();

        $this->defaultPaymentMethod = $defaultPaymentMethod;

        $openingAmount = floatval($denominationNumberCoin) * $denomination->getDenominationValue();
        $closingAmount = floatval($denominationNumberCoin) * $denomination->getDenominationValue();
        $payIn = floatval($putMoneyInValue);
        $payOut = floatval($takeMoneyOutValue);
        $cashSales = $this->convertPriceFormatToDecimal($cashSales);
        $otherPaymentSales = $this->convertPriceFormatToDecimal($otherPaymentSales);
        $discountAmount = floatval($discountAmount);
        return [
            'openingAmount' => $openingAmount,
            'closingAmount' => $closingAmount,
            'totalSales' => $cashSales + $otherPaymentSales,
            'payIn' => $payIn,
            'payOut' => $payOut,
            'cashSales' => $cashSales,
            'cashRefund' => 0,
            'otherPaymentSales' => $otherPaymentSales,
            'discountAmount' => $discountAmount,
            'refund' => 0
        ];
    }

    public function tearDown()
    {
//        $this->objectManager->create(
//            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
//            ['dataConfig' => $this->dataConfigToNo]
//        )->run();
//
//        //Config Payment Payment Method
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => $this->defaultPaymentMethod]
//        )->run();
    }

    public function convertPriceFormatToDecimal($string)
    {
        $result = null;
        $negative = false;
        if ($string[0] === '-') {
            $negative = true;
            $string = str_replace('-', '', $string);
        }
        $string = str_replace('$', '', $string);
        $result = floatval($string);
        if ($negative) {
            $result = -1 * abs($result);
        }
        return $result;
    }
}