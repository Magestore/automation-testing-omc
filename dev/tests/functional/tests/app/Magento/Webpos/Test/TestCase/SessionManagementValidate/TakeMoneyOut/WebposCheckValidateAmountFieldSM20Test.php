<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/21/18
 * Time: 9:27 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\SessionManagementValidate\TakeMoneyOut\AssertWebposCheckValidateAmountFieldSM20SM21;
/**
 * Class WebposCheckValidateAmountFieldSM20Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * SM20
 * "Precondition: Settings [Need to create session before working] = Yes
    1. Login webpos by an account who has opening session permission
    2. Click to show left menu
    3. Click on [Session management] menu > Open a new session successfully "
 * Steps:
    1. Click on [Put money in] button
    2. Click on [Done] button"
 */
class WebposCheckValidateAmountFieldSM20Test extends Injectable
{
    /**
     * WebposIndex Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * AssertWebposCheckValidateAmountFieldSM20SM21.
     *
     * @var AssertWebposCheckValidateAmountFieldSM20SM21 $assertWebposCheckValidateAmountFieldSM20SM21
     */
    protected $assertWebposCheckValidateAmountFieldSM20SM21;

    protected $dataConfigToNo;

    protected $configuration;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckValidateAmountFieldSM20SM21 $assertWebposCheckValidateAmountFieldSM20SM21
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckValidateAmountFieldSM20SM21 $assertWebposCheckValidateAmountFieldSM20SM21
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckValidateAmountFieldSM20SM21 = $assertWebposCheckValidateAmountFieldSM20SM21;
    }

    /**
     * @param $dataConfig
     * @param $dataConfigToNo
     */
    public function test($dataConfig, $dataConfigToNo)
    {
        $this->dataConfigToNo = $dataConfigToNo;
        //Set Create Session Before Working to Yes
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfig]
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();


        // Open session
        $time = time();
        $timeAfter = $time + 10;
        while (!$this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()
            && $time < $timeAfter){
            $time = time();
        }
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getSessionInfo()->waitForTakeMoneyOutButton();
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        $this->assertWebposCheckValidateAmountFieldSM20SM21->processAssert($this->webposIndex);
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $this->dataConfigToNo]
        )->run();

        $this->webposIndex->getPutMoneyInPopup()->getBtnCancel()->click();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        $this->webposIndex->getSessionShift()->waitButtonEndSessionIsVisible();
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionShift()->waitBtnCloseSessionNotVisible();
    }
}