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
/**
 * Class WebposCheckValidateAmountFieldSM23Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * SM23
 *  Precondition: Settings [Need to create session before working] = Yes
1. Login webpos by an account who has opening session permission
2. Click to show left menu
3. Click on [Session management] menu > Open a new session successfully  with opening amount = 100"
 * SM23 - Steps:
1. Click on [Take money out] button
2. Input into [Amount] field greater than 100 (Ex: 200)
3. Click on [Done] button"
 */
class WebposCheckValidateAmountFieldSM23Test extends Injectable
{
    /**
     * WebposIndex Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    protected $dataConfigToNo;

    protected $configuration;

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
     * @param $dataConfig
     * @param $dataConfigToNo
     * @param $openingAmount
     * @return array
     */
    public function test($dataConfig, $dataConfigToNo, $openingAmount, $amountValue)
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
        $timeAfter = $time + 5;
        while (!$this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()
            && $time < $timeAfter){
            $time = time();
        }
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-open-shift"]');
        sleep(1);
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue($openingAmount);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
        sleep(1);
        $this->webposIndex->getSessionInfo()->waitForTakeMoneyOutButton();
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue($amountValue);
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        return [
            'staff' => $staff
        ];
    }

    public function tearDown()
    {
        //Set Create Session Before Working to No
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $this->dataConfigToNo]
        )->run();
        //Set Create Session Before Working to No
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AdminCloseCurrentSessionStep'
        )->run();
    }
}