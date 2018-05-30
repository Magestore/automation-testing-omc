<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportZR008Test
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
class WebposZreportZR008Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $products
     * @param Denomination $denomination
     * @param $denominationNumberCoin
     * @return array
     */
    public function test(
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

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            [
                'products' => $products,
                'paymentMethod' => 'cp1forpos'
            ]
        )->run();

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
        $totalSales = $this->webposIndex->getSessionShift()->getPaymentAmount()->getText();

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();

        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'closedString' => $closedString,
            'totalSales' => $this->convertPriceFormatToDecimal($totalSales)
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