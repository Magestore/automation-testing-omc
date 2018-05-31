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
 * Class WebposZreportCheckGUITest
 * @package Magento\Webpos\Test\TestCase\Zreport
 * ZR001
 * Precondition and setup steps
 * Precondition: There are some POSs and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session
 * 3. Create some orders successfully"
 *
 * Steps:
 * 1. Go to [Session Management] menu
 * 2. Click on [End of Session] > Input real money > [Confirm] > Close session successfully
 * 3. Click on [Print] button
 *
 * Acceptance:
 * "3. Show Z-report including:
 * - Title: Z-report
 * - Session #session ID
 *
 * - POS: Current POS
 * - Staff: Staff name who printed the sesstion
 * - Opened: Time and Staff name who opened the session
 * - Closed: Time and Staff name who closed the session
 * # Cash
 * - Opening amount
 * - Closing amount
 * - Theoretical Closing Amount
 * - Difference
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
 * # Sale by payment methods: List of all payment methods that used to pay on webpos in this session with thier amounts
 * Time to print the Z-report"
 *
 *
 * ZR002
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Choose an available POS (ex: POS 1)
 * 3. Open a session
 * 4. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully
 * 3. Click to print Z-report
 *
 * Acceptance Criteria
 * 3. [POS] field will show name of the current POS (POS 1)
 *
 * ZR003
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission (ex: Staff A)
 * 2. Open a session
 * 3. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully
 * 3. Click to print Z-report
 *
 * Acceptance Criteria
 * 3. [Staff] field will show name of the current staff (Staff A)
 *
 * ZR006
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission (ex: Staff A)
 * 2. Open a session
 * 3. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully
 * 3. Click to print Z-report
 *
 * Acceptance Criteria
 * 3.
 * - [Opened] field: show opened Date & Time and the staff name who opened this session  (staff A)
 * - [Closed] field: show closed Date & Time and the staff name who closed this session (staff A)
 *
 * ZR019
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session with
 * - Opening amount = 0
 * 3. Create some orders successfully "	"Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff who has open and close session permission
 * 2. Open a session with
 * - Opening amount = 0
 * 3. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Close the session successfully
 * 3. Click to print Z-report
 *
 * Acceptance Criteria
 * 3. Show printing time of Z-report on the bottom of the report
 */
class WebposZreportCheckGUITest extends Injectable
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

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposSetClosingBalanceCloseSessionStep',
            [
                'denomination' => $denomination,
                'denominationNumberCoin' => $denominationNumberCoin
            ]
        )->run();

        $staffName = $this->webposIndex->getSessionShift()->getStaffName()->getText();
        $openedString = $this->webposIndex->getSessionShift()->getOpenTime()->getText();
        $openedString .= ' by ' . $staffName;
        $closedString = $this->webposIndex->getSessionShift()->getCloseTime()->getText();
        $closedString .= ' by ' . $staffName;

        $this->webposIndex->getSessionShift()->getPrintButton()->click();
        $this->webposIndex->getSessionShift()->waitReportPopupVisible();
        return [
            'staffName' => $staffName,
            'openedString' => $openedString,
            'closedString' => $closedString
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