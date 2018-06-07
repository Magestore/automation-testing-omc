<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 16/05/2018
 * Time: 14:21
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencyIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportZR017Test
 * @package Magento\Webpos\Test\TestCase\Zreport
 *
 * Precondition:
 * - There are some POS and setting [Need to create session before working] = "Yes" on the test site
 * - Setup multi currencies
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Go to General > Currency > Select a currency that different from default currency
 * 3. Open a session with conditions:
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
 * 3. All of fields on Z-report will be show exactly the symbol and converting rate of the currency that selected on step 2 of [Precondition and setup steps]
 *
 */
class WebposZreportZR017Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var SystemCurrencyIndex $currencyIndex
     */
    protected $currencyIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @param WebposIndex $webposIndex
     * @param SystemCurrencyIndex $currencyIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        SystemCurrencyIndex $currencyIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->currencyIndex = $currencyIndex;
    }

    /**
     * @param $products
     * @param Denomination $denomination
     * @param $denominationNumberCoin
     * @param $amount
     * @param $putMoneyInValue
     * @param $takeMoneyOutValue
     * @param string $discountAmount
     * @param $menuItem
     * @param $symbol
     * @return array
     */
    public function test(
        $products,
        Denomination $denomination,
        $denominationNumberCoin,
        $amount,
        $putMoneyInValue,
        $takeMoneyOutValue,
        $discountAmount = '',
        $menuItem,
        $symbol
    )
    {
        // Create denomination
        $denomination->persist();
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'config_default_currency_uah']
        )->run();

        //Config Customer Credit Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'magestore_webpos_custome_payment']
        )->run();

        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\AdminCloseCurrentSessionStep'
        )->run();

        $this->currencyIndex->open();
        $this->currencyIndex->getCurrencyRateForm()->clickImportButton();
        $this->currencyIndex->getCurrencyRateForm()->fillCurrencyUSDUAHRate();
        $this->currencyIndex->getFormPageActions()->save();

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        // Open session
        $time = time();
        $timeAfter = $time + 3;
        while (!$this->webposIndex->getOpenSessionPopup()->isVisible()
            && $time < $timeAfter) {
            $time = time();
        }
        if ($this->webposIndex->getOpenSessionPopup()->isVisible()) {
            $this->webposIndex->getOpenSessionPopup()->waitLoader();
            $this->webposIndex->getOpenSessionPopup()->getCancelButton()->click();

            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->general();
            sleep(1);
            $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
            $this->webposIndex->getGeneralSettingContentRight()->waitCurrencySelectionVisible();
            $this->webposIndex->getGeneralSettingContentRight()->getCurrencySelection()->setValue('Ukrainian Hryvnia');

            $this->webposIndex->getMsWebpos()->waitForCMenuVisible();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
            sleep(1);
        }

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

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddDiscountWholeCartStep',
            [
                'percent' => $discountAmount,
                'type' => '$'
            ]
        )->run();

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
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitForFirstOrderVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForFormAddNoteOrderVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        $this->webposIndex->getModal()->waitForModalPopup();
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getModal()->waitForModalPopupNotVisible();

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
        $cashSales = $this->convertPriceFormatToDecimal($cashSales, $symbol);
        $otherPaymentSales = $this->convertPriceFormatToDecimal($otherPaymentSales, $symbol);
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
            'refund' => $cashSales,
            'symbol' => $symbol
        ];
    }

    /**
     * convert string price format to decimal
     * @param $string
     * @param $symbol
     * @return float|int|null
     */
    public function convertPriceFormatToDecimal($string, $symbol = '$')
    {
        $result = null;
        $negative = false;
        if ($string[0] === '-') {
            $negative = true;
            $string = str_replace('-', '', $string);
        }
        $string = str_replace($symbol, '', $string);
        $result = floatval($string);
        if ($negative) {
            $result = -1 * abs($result);
        }
        return $result;
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

        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'config_default_currency_rollback']
        )->run();
    }
}