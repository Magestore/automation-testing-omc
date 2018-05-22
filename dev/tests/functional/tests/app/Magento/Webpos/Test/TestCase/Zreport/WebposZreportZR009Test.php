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
 * Class WebposZreportZR009Test
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = "Yes" on the test site
 * 1. LoginTest webpos by a staff who has open and close session permission
 * 2. Open a session with
 * - Opening amount = 0
 * 3. Create some orders successfully with some payment methods which are not cash in
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully with:
 * - Closing amount = 0
 * 3. Click to print Z-report
 *
 * Acceptance:
 * 3. Show Z-report with:
 * - Opening Amount = 0
 * - Closing Amount = 0
 * - Theoretical Closing Amount = 0
 * - Difference = 0
 *
 * - Cash sales = 0
 * - Cash Refund = 0
 * - Pay Ins = 0
 * - Payouts = 0
 *
 * - Total Sales = SUM(grand_total) of the orders which placed on this session
 * - Discount = 0
 * - Refund = 0
 * - Net Sales = Total Sales
 *
 * And show all of the payment methods with their total that placed on this session
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposZreportZR009Test extends Injectable
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
                         $defaultPaymentMethod, $amount)
    {
        // Create denomination
        $denomination->persist();
        $this->dataConfigToNo = $dataConfigToNo;
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $dataConfig]
        )->run();

        //Config Customer Credit Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfigPayment]
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(1);
            $i++;
        }

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $totalSales = $this->webposIndex->getCheckoutCartFooter()->getTotalElement()->getText();
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);
        $this->webposIndex->getCheckoutPaymentMethod()->getTitlePaymentMethod()->click();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->click();
        $this->webposIndex->getCheckoutAddMorePayment()->getCashIn()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposSetClosingBalanceCloseSessionStep',
            [
                'denomination' => $denomination,
                'denominationNumberCoin' => $denominationNumberCoin
            ]
        )->run();

        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $closedString = $this->webposIndex->getSessionShift()->getCloseTime()->getText();
        $staffName = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $cashSales = $this->webposIndex->getSessionShift()->getPaymentAmount(1)->getText();
        $otherPaymentSales = $this->webposIndex->getSessionShift()->getPaymentAmount(2)->getText();

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitZreportVisible();

        $this->defaultPaymentMethod = $defaultPaymentMethod;

        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'closedString' => $closedString,
            'totalSales' => $this->convertPriceFormatToDecimal($totalSales),
            'cashSales' => $this->convertPriceFormatToDecimal($cashSales),
            'otherPaymentSales' => $this->convertPriceFormatToDecimal($otherPaymentSales)
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\WebposConfigurationStep',
            ['dataConfig' => $this->dataConfigToNo]
        )->run();

        //Config Payment Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $this->defaultPaymentMethod]
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