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
 * Class WebposZreportZR009Test
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = "Yes" on the test site
 * 1. Login webpos by a staff who has open and close session permission
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
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * @param $products
     * @param Denomination $denomination
     * @param $denominationNumberCoin
     * @param $amount
     * @return array
     */
    public function test(
        $products,
        Denomination $denomination,
        $denominationNumberCoin,
        $amount
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

        // Login webpos
        $this->objectManager->getInstance()->create(
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
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();

        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'closedString' => $closedString,
            'totalSales' => $this->convertPriceFormatToDecimal($totalSales),
            'cashSales' => $this->convertPriceFormatToDecimal($cashSales),
            'otherPaymentSales' => $this->convertPriceFormatToDecimal($otherPaymentSales)
        ];
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
}