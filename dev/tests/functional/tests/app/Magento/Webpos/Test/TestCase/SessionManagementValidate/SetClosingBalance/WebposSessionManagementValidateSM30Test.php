<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/12/2018
 * Time: 1:31 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertConfirmModalPopup;

/**
 * Class WebposSessionManagementValidateSM30Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM30Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertConfirmModalPopup
     */
    protected $assertConfirmModalPopup;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertConfirmModalPopup $assertConfirmModalPopup
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertConfirmModalPopup $assertConfirmModalPopup
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertConfirmModalPopup = $assertConfirmModalPopup;
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

        $realBalance = $this->webposIndex->getSessionConfirmModalPopup()->getRealBalance();
        $theoryIs = $this->webposIndex->getSessionConfirmModalPopup()->getTheoryIs();
        $loss = $this->webposIndex->getSessionConfirmModalPopup()->getLoss();

        $this->assertConfirmModalPopup->processAssert($this->webposIndex, $realBalance, $theoryIs, $loss);
        $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();

        $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
        $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
        sleep(1);
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