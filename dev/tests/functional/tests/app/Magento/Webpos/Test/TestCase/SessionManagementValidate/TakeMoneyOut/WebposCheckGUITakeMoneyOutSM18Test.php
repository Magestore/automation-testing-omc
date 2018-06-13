<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/21/18
 * Time: 8:15 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Config\Test\Fixture\ConfigData;

/**
 * Class WebposCheckGUITakeMoneyOutSM18Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * Settings [Need to create session before working] = Yes
 * 1. Login webpos by an account who has opening session permission
 * 2. Click to show left menu
 * 3. Click on [Session management] menu > Open a new session successfully "
 * Step:
 * 1. Click on [Take money out] button
 *
 */
class WebposCheckGUITakeMoneyOutSM18Test extends Injectable
{
    /**
     * WebposIndex Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return array
     */
    public function test()
    {
        //Set Create Session Before Working to Yes
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();
        $username = $staff->getUsername();

        // Open session
        $time = time();
        $timeAfter = $time + 5;
        while (!$this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()
            && $time < $timeAfter) {
            $time = time();
        }
        if (!$this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()) {
            $this->webposIndex->getMsWebpos()->cmenuButtonIsVisible();
            $this->webposIndex->getMsWebpos()->getCMenuButton()->click();
            $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
            $this->webposIndex->getCMenu()->getSessionManagement();
            sleep(0.5);
            while (!$this->webposIndex->getSessionShift()->isVisible()) {
                $this->webposIndex->getCMenu()->getSessionManagement();
                sleep(0.5);
            }
            $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
            sleep(1);
            $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
            sleep(0.5);
            if ($this->webposIndex->getSessionConfirmModalPopup()->isVisible()) {
                $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
                $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupVisible();
            }
            $this->webposIndex->getSessionCloseShift()->waitSetClosingBalancePopupNotVisible();
            // End session
            $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
            $this->webposIndex->getSessionShift()->waitBtnCloseSessionNotVisible();
            $this->webposIndex->getSessionShift()->getAddSession()->click();
        }
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        sleep(1);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
        sleep(1);
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-make-adjustment"]');
        return [
            'username' => $username
        ];
    }

    public function tearDown()
    {
        //Set Create Session Before Working to No
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }
}