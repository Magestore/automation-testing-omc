<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportZR010Test
 * @package Magento\Webpos\Test\TestCase\Zreport
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = "Yes" on the test site
 * 1. LoginTest webpos by a staff who has open and close session permission
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
 */
class WebposZreportZR010Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

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

    public function test(
        $products,
        Denomination $denomination,
        $denominationNumberCoin,
        $amount,
        $putMoneyInValue,
        $takeMoneyOutValue,
        $addDiscount = false,
        $discountAmount = ''
    )
    {
        // Create denomination
        $denomination->persist();
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

        //Config Customer Credit Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'magestore_webpos_custome_payment']
        )->run();

        // LoginTest webpos
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
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // phai sleep vi payment co khi bi xoa
        sleep(2);
        if (!$this->webposIndex->getCheckoutPaymentMethod()->getIconRemove()->isVisible()) {
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
            $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->click();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);
        $this->webposIndex->getCheckoutPaymentMethod()->getTitlePaymentMethod()->click();

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
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForFormAddNoteOrderVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        $this->webposIndex->getBody()->waitForModalPopup();
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getBody()->waitForModalPopupNotVisible();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposSetClosingBalanceCloseSessionStep',
            [
                'denomination' => $denomination,
                'denominationNumberCoin' => $denominationNumberCoin
            ]
        )->run();

        $cashSales = $this->webposIndex->getSessionShift()->getPaymentAmount(1)->getText();
        $otherPaymentSales = $this->webposIndex->getSessionShift()->getPaymentAmount(2)->getText();

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();

        $openingAmount = floatval($denominationNumberCoin) * $denomination->getDenominationValue();
        $closingAmount = floatval($denominationNumberCoin) * $denomination->getDenominationValue();
        $payIn = floatval($putMoneyInValue);
        $payOut = floatval($takeMoneyOutValue);
        $cashSales = $this->convertPriceFormatToDecimal($cashSales);
        $otherPaymentSales = $this->convertPriceFormatToDecimal($otherPaymentSales);
        $discountAmount = floatval($discountAmount);
        $totalSales = $cashSales + $otherPaymentSales;
        return [
            'openingAmount' => $openingAmount,
            'closingAmount' => $closingAmount,
            'totalSales' => $totalSales,
            'payIn' => $payIn,
            'payOut' => $payOut,
            'cashSales' => $cashSales,
            'cashRefund' => 0,
            'otherPaymentSales' => $otherPaymentSales,
            'discountAmount' => $discountAmount,
            'refund' => $totalSales
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();

        //Config Payment Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'magestore_webpos_specific_payment']
        )->run();
    }

    /**
     * convert string price format to decimal
     * @param $string
     * @return float|int|null
     */
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