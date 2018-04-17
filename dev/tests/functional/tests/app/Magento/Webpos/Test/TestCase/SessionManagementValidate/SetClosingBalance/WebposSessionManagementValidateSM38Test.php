<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 3:36 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSessionManagementValidateSM38Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM38Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    ) {
        $this->webposIndex = $webposIndex;
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
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionShift()->waitForElementNotVisible('.btn-close-shift');
        sleep(2);

        // Assert
        $this->assertFalse(
            $this->webposIndex->getSessionShift()->getPutMoneyInButton()->isVisible(),
            'Put Money In Button is visible.'
        );
        $this->assertFalse(
            $this->webposIndex->getSessionShift()->getTakeMoneyOutButton()->isVisible(),
            'Take Money Out Button is visible.'
        );
        $this->assertFalse(
            $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->isVisible(),
            'Set Closing Balance Button is visible.'
        );
        $this->assertFalse(
            $this->webposIndex->getSessionShift()->getButtonEndSession()->isVisible(),
            'Validate Closing Button is visible.'
        );
        $this->assertTrue(
            $this->webposIndex->getSessionShift()->getCloseTime()->isVisible(),
            'Time Of Close Session is not visible.'
        );
        $this->assertTrue(
            $this->webposIndex->getSessionShift()->getOpenShiftButton()->isVisible(),
            'Add Session button is not visible.'
        );
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