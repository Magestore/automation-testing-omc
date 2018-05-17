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
 * Class WebposZreportCheckGUITest
 *
 * Precondition: There are some POSs and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Open a session successfully > click on [Print] button
 *
 * Acceptance:
 * 2. Show X-report including:
 * - Title: X-report
 * - Session #session ID
 *
 * - POS: Current POS
 * - Staff: Staff name who printed the sesstion
 * - Opened: Date Time and Staff name who opened the session
 *
 * # Cash
 * - Opening amount
 * - Expected Drawer
 *
 * - Cash sales
 * - Cash refund
 * - Pay ins
 * - Payouts
 * #Sales
 * - Total Sales
 * - Discount
 * - Refund
 * - Net Sales
 * # Sale by payment methods
 *
 * Time to print the X-report
 *
 * @package Magento\Webpos\Test\TestCase\Zreport
 */
class WebposXreportCheckGUITest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposSetClosingBalanceCloseSessionStep'
        )->run();

        $staffName = $this->webposIndex->getSessionShift()->getStaffName()->getText();
        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $openedString .= ' by ' . $staffName;

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();
        return [
            'staffName' => $staffName,
            'openedString' => $openedString
        ];
    }

    public function tearDown()
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'setup_session_before_working_to_no']
        )->run();
    }
}