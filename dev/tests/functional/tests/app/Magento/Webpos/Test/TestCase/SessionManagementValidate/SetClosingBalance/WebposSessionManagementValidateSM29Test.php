<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 4:37 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\SessionManagement\AssertSetClosingBalancePopupNotVisible;

/**
 * Class WebposSessionManagementValidateSM29Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\SetClosingBalance
 */
class WebposSessionManagementValidateSM29Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertSetClosingBalancePopupNotVisible
     */
    protected $assertSetClosingBalancePopupNotVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertSetClosingBalancePopupNotVisible $assertSetClosingBalancePopupNotVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertSetClosingBalancePopupNotVisible $assertSetClosingBalancePopupNotVisible
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertSetClosingBalancePopupNotVisible = $assertSetClosingBalancePopupNotVisible;
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
        sleep(1);
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        sleep(1);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getCancelButton()->click();

        $this->assertSetClosingBalancePopupNotVisible->processAssert($this->webposIndex);

        // End session
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