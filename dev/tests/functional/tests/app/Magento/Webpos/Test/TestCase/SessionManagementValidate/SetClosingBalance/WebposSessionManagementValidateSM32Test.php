<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 8:01 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertConfirmModalPopupNotVisible;

/**
 * Class WebposSessionManagementValidateSM32Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM32Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertConfirmModalPopupNotVisible
     */
    protected $assertConfirmModalPopupNotVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertConfirmModalPopupNotVisible $assertConfirmModalPopupNotVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertConfirmModalPopupNotVisible $assertConfirmModalPopupNotVisible
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertConfirmModalPopupNotVisible = $assertConfirmModalPopupNotVisible;
    }

    /**
     * @param Denomination $denomination
     */
    public function test(
        Denomination $denomination
    ) {
        // Precondition
        $denomination->persist();

        // Config create session before working
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
        $this->webposIndex->getOpenSessionPopup()->waitForElementNotVisible('[data-bind="visible:loading"]');
        $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($denomination->getDenominationName());
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue(10);

        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        sleep(1);
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionConfirmModalPopup()->getCancelButton()->click();

        // Assert Confirm Modal Popup Not visible
        $this->assertConfirmModalPopupNotVisible->processAssert($this->webposIndex);

        // Assert [End of session] button changes into [Validate Closing] button
        $this->assertEquals(
            'Validate Closing',
            $this->webposIndex->getSessionShift()->getButtonEndSession()->getText(),
            'Button "Validate Closing" is not visible.'
        );

        sleep(2);
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