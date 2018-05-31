<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 18/05/2018
 * Time: 08:14
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposXreportZR027Test
 *
 * Precondition: There are some POS and setting [Need to create session before working] = "Yes" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session with
 * - Opening amount = 0
 * 3. Create some orders successfully with some payment methods (including cashin method)
 *
 * Steps:
 * "1. Go to [Session Management] menu
 * 2. Click to print X-report"
 *
 * Acceptance:
 * "2. Show X-report with:
 * - Opening Amount = 0
 * - Expected Drawer = Cash Sales
 *
 * - Cash sales = The total cash sales processed including discounts and tax on this session
 * - Cash Refund = 0
 * - Pay Ins = 0
 * - Payouts = 0
 *
 * - Total Sales = SUM(grand_total) of the orders which placed on this session
 * - Discount = 0
 * - Refund = 0
 * - Net Sales = Total Sales
 *
 * - Cash in= [Cash sales]
 * And show all of the payment methods with their total that placed on this session"
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposXreportZR027Test extends Injectable
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
     * @param $amount
     * @return array
     */
    public function test(
        $products,
        $amount
    )
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

        //Config Customer Credit Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'magestore_webpos_custome_payment']
        )->run();

        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\AdminCloseCurrentSessionStep'
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
        $totalSales = $this->webposIndex->getCheckoutCartFooter()->getTotalElement()->getText();
        $this->webposIndex->getCheckoutPaymentMethod()->waitForCustomPayment1Method();
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);
        $this->webposIndex->getMainContent()->waitForMsWebpos();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->click();
        $this->webposIndex->getCheckoutAddMorePayment()->getCashIn()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->waitForSessionManagerLoader();

        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $staffName = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $cashSales = $this->webposIndex->getSessionShift()->getPaymentAmount(1)->getText();
        $otherPaymentSales = $this->webposIndex->getSessionShift()->getPaymentAmount(2)->getText();

        $totalSales = $this->convertPriceFormatToDecimal($totalSales);
        $cashSales = $this->convertPriceFormatToDecimal($cashSales);
        $otherPaymentSales = $this->convertPriceFormatToDecimal($otherPaymentSales);

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();

        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'totalSales' => $totalSales,
            'cashSales' => $cashSales,
            'otherPaymentSales' => $otherPaymentSales,
            'expectedDrawer' => $totalSales
        ];
    }

    /**
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

        $this->objectManager->create(
            'Magento\Webpos\Test\TestStep\AdminCloseCurrentSessionStep'
        )->run();
    }
}