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
 * Class WebposXreportZR032Test
 * @package Magento\Webpos\Test\TestCase\Zreport
 *
 * Precondition: There are some POS and setting [Need to create session before working] = "Yes" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session
 * 3. Create some orders successfully
 * 4. Refund an order that placed on the previous session
 * - Refund by cash in (Ex: R amount)
 * - Refund by other payments (not cash in) (Ex: N amount)
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 3. Click to print X-report
 *
 * Acceptance:2.
 * - Cash Refund = Refund amount by cashin (R amount)
 * - Refund =Total Refunded amount by all methods on step 4 of [Precondition and setup steps]  (R+N amount)
 *
 */
class WebposXreportZR032Test extends Injectable
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
     * @param $amount
     * @param $products
     * @param Denomination $denomination
     * @param $denominationNumberCoin
     * @return array
     */
    public function test(
        $amount,
        $products,
        Denomination $denomination,
        $denominationNumberCoin
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
            $productFixture = $this->fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($productFixture->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
        }
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->waitForCustomPayment1Method();
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment1()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
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

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->logout();
        $this->webposIndex->getModal()->waitForModalPopup();
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getModal()->waitForModalPopupNotVisible();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader.loading-mask');

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        // Refund
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();
        sleep(1);
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->waitForFormAddNoteOrderVisible();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Refund')->click();
        $this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();
        $this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
        $this->webposIndex->getModal()->waitForModalPopup();
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getModal()->waitForModalPopupNotVisible();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->waitForSessionManagerLoader();

        $totalSales = $this->webposIndex->getSessionShift()->getPaymentAmount()->getText();
        $refund = (-1) * $totalSales;

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();

        return [
            'refund' => $refund,
            'cashRefund' => 0
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