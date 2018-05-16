<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 16/05/2018
 * Time: 14:21
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\CurrencySymbol\Test\Page\Adminhtml\SystemCurrencyIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportZR017Test
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposZreportZR017Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    protected $dataConfigToNo;

    protected $defaultPaymentMethod;

    protected $dataConfigCurrencyRollback;

    /**
     * @var SystemCurrencyIndex
     */
    protected $currencyIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;


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

    public function test(
        $products,
        Denomination $denomination,
        $denominationNumberCoin,
        ConfigData $dataConfig,
        ConfigData $dataConfigToNo,
        $dataConfigCurrency,
        $dataConfigCurrencyRollback,
        $dataConfigPayment,
        $defaultPaymentMethod,
        $amount,
        $putMoneyInValue,
        $takeMoneyOutValue,
        $addDiscount = false,
        $discountAmount = '',
        $menuItem
    )
    {
        // Create denomination
        $denomination->persist();
//        $this->dataConfigToNo = $dataConfigToNo;
//        $this->objectManager->create(
//            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
//            ['dataConfig' => $dataConfig]
//        )->run();

//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => $dataConfigCurrency]
//        )->run();

//        //Config Customer Credit Payment Method
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => $dataConfigPayment]
//        )->run();

//        $this->currencyIndex->open();
//        $this->currencyIndex->getCurrencyRateForm()->clickImportButton();
//        $this->currencyIndex->getCurrencyRateForm()->fillCurrencyUSDUAHRate();
//        $this->currencyIndex->getFormPageActions()->save();

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
        if ($this->webposIndex->getOpenSessionPopup()->isVisible())
        {
            $this->webposIndex->getOpenSessionPopup()->waitLoader();
            $this->webposIndex->getOpenSessionPopup()->getCancelButton()->click();

            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->general();
            sleep(1);
            $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
            $this->webposIndex->getGeneralSettingContentRight()->waitCurrencySelectionVisible();
            $this->webposIndex->getGeneralSettingContentRight()->getCurrencySelection()->setValue('Ukrainian Hryvnia');

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
        $this->webposIndex->getCheckoutPaymentMethod()->waitForCashInMethod();
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // phai sleep vi payment co khi bi xoa
        sleep(3);
        if (!$this->webposIndex->getCheckoutPaymentMethod()->getIconRemove()->isVisible()) {
            $this->webposIndex->getCheckoutPaymentMethod()->waitForCashInMethod();
            $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->click();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);
        $this->webposIndex->getMainContent()->waitForMsWebpos();
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
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $orderId = $this->webposIndex->getOrderHistoryOrderList()->getFirstOrderId();
        \Zend_Debug::dump($orderId);
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForChangeOrderId($orderId);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForFormAddNoteOrderVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);

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
        $this->webposIndex->getSessionShift()->waitZreportVisible();

        $this->defaultPaymentMethod = $defaultPaymentMethod;
        $this->dataConfigCurrencyRollback = $dataConfigCurrencyRollback;

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
//
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => $this->dataConfigCurrencyRollback]
//        )->run();
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