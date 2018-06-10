<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 09/05/2018
 * Time: 13:30
 */

namespace Magento\Webpos\Test\TestCase\Xreport;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposZreportCheckGUI2Test
 * @package Magento\Webpos\Test\TestCase\Xreport
 * ZR021
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
 * Time to print the X-report
 *
 * ZR022
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff
 * 2. Choose an available POS (ex: POS 1)
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Open a session successfully > click on [Print] button
 *
 * Acceptance Criteria
 * 2. [POS] field will show name of the current POS (POS 1)
 *
 * ZR023
 * Precondition and setup steps:
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff (ex: Staff A)
 * 2. Open a session
 * 3. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Click on [Print] button
 *
 * Acceptance Criteria
 * 2. [Staff] field will show name of the current staff (Staff A)
 *
 * ZR025
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff (ex: Staff A)
 * 2. Open a session
 * 3. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Click to print X-report
 *
 * Acceptance Criteria
 * 2.
 * - [Opened] field: show opened Date & Time and the staff name who opened this session  (staff A)
 *
 * ZR034
 * Precondition and setup steps
 * Precondition: There are some POS and setting [Need to create session before working] = ""Yes"" on the test site
 * 1. Login webpos by a staff
 * 2. Open a session with
 * - Opening amount = 0
 * 3. Create some orders successfully
 *
 * Steps
 * 1. Go to [Session Management] menu
 * 2. Click to print X-report
 *
 * Acceptance Criteria
 * 2. Show exactly printing time of X-report on the bottom of the report
 */
class WebposXreportCheckGUITest extends Injectable
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
     * @return array
     */
    public function test(
        $products
    )
    {
        $this->objectManager->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_session_before_working']
        )->run();

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

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->waitForSessionManagerLoader();

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