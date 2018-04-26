<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/15/2018
 * Time: 8:31 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\CheckPrintButton;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSessionManagementValidateSM39Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\CheckPrintButton
 */
class WebposSessionManagementValidateSM39Test extends Injectable
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
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        // Open session
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getSessionShift()->getPrintButton()->click();

        // Assert
        $this->assertTrue(
            $this->webposIndex->getSessionPrintShiftPopup()->isVisible(),
            'X-report is not visible.'
        );

        $this->webposIndex->getSessionShift()->getHidePopup()->click();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
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