<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 2:23 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertCheckGUIOnSetClosingBalancePopup;

/**
 * Class WebposSessionManagementValidateSM37Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM37Test extends Injectable
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
            'Magento\Webpos\Test\TestStep\LoginWebposChooseLocationStep'
        )->run();

        // Open session
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();

        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();

        // Assert Set Closing Balance Popup visible
        $this->assertTrue(
            $this->webposIndex->getSessionSetClosingBalancePopup()->isVisible(),
            'Set Closing Balance Popup is not visible.'
        );

        // End session
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
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