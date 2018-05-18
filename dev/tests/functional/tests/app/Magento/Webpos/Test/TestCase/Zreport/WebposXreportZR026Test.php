<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposXreportZR026Test
 *
 * Precondition: There are some POS and setting [Need to create session before working] = "Yes" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session with
 * - Opening amount = 0
 * 3. Create some orders successfully with some payment methods which are not cash in
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Click to print X-report
 *
 * Acceptance:
 * 2. Show X-report with:
 * - Opening Amount = 0
 * - Expect Drawer = 0
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
 * - Cash in = 0
 * And show all of the payment methods with their total that placed on this session
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposXreportZR026Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;
    protected $useOtherPaymentMethod;

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        $products
    )
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

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

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            [
                'products' => $products,
                'paymentMethod' => 'cp1forpos'
            ]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);

        $staffName = $this->webposIndex->getSessionShift()->getStaffName()->getText();
        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $openedString .= ' by ' . $staffName;
        $totalSales = $this->webposIndex->getSessionShift()->getPaymentAmount()->getText();

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();
        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'totalSales' => $this->convertPriceFormatToDecimal($totalSales),
            'expectedDrawer' => 0
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();

        if ($this->useOtherPaymentMethod) {
            $this->objectManager->getInstance()->create(
                'Magento\Config\Test\TestStep\SetupConfigurationStep',
                ['configData' => 'magestore_webpos_specific_payment']
            )->run();
        }
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