<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Zreport;

use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportZR008Test
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
class WebposZreportZR008Test extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    protected $dataConfigToNo;

    protected $defaultPaymentMethod;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products, Denomination $denomination,
                         $denominationNumberCoin,
                         ConfigData $dataConfig, ConfigData $dataConfigToNo,
                         $dataConfigPayment,
                         $defaultPaymentMethod)
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

        // Login webpos
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

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        // Set closing balance
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        $this->webposIndex->getSessionSetClosingBalancePopup()->getColumnNumberOfCoinsAtRow(2)->setValue($denominationNumberCoin);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(2);
        if($this->webposIndex->getSessionConfirmModalPopup()->isVisible())
        {
            $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
            $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
            $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
        }
        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        sleep(1);

        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $closedString = $this->webposIndex->getSessionShift()->getCloseTime()->getText();
        $staffName = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $totalSales = $this->webposIndex->getSessionShift()->getPaymentAmount()->getText();

        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitZreportVisible();

        $this->defaultPaymentMethod = $defaultPaymentMethod;

        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'closedString' => $closedString,
            'totalSales' => $totalSales
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
}