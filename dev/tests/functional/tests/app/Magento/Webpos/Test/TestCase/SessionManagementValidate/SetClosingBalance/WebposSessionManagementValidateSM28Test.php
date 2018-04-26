<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 2:13 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertCheckGUIOnSetClosingBalancePopup;

/**
 * Class WebposSessionManagementValidateSM28Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM28Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertCheckGUIOnSetClosingBalancePopup
     */
    protected $assertCheckGUIOnSetClosingBalancePopup;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertCheckGUIOnSetClosingBalancePopup $assertCheckGUIOnSetClosingBalancePopup
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertCheckGUIOnSetClosingBalancePopup $assertCheckGUIOnSetClosingBalancePopup
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertCheckGUIOnSetClosingBalancePopup = $assertCheckGUIOnSetClosingBalancePopup;
    }

    /**
     *
     */
    public function test()
    {
        //Config create session before working
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        // Open session
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        sleep(1);
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        sleep(1);
        $this->assertCheckGUIOnSetClosingBalancePopup->processAssert($this->webposIndex);

        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();

        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
    }

    /**
     *
     */
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }
}