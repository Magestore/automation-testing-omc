<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/23/18
 * Time: 4:59 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCheckFieldsWhenTakingMoneyOutTwiceSM26Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * "Precondition: Settings [Need to create session before working] = Yes
 * 1. Login webpos by an account who has opening session permission
 * 2. Click to show left menu
 * 3. Click on [Session management] menu > Open a new session successfully with opening amount = 100"
 * Steps
 * "1. Click on [Take money out] button
 * 2. Input positive number into [Amount] field (Ex: 10)
 * 3. Click on [Done] button
 * 4. Click on [Put money in] button again > input 30 into [Amount] > Done"
 */
class WebposCheckFieldsWhenTakingMoneyOutTwiceSM26Test extends Injectable
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
    public function test($dataConfig, $dataConfigToNo, $openingAmount, $amountValue, $realOpeningAmount, $reasonTransaction, $pushMoneyIn)
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
            && $time < $timeAfter) {
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
        if ($reasonTransaction != null) {
            $this->webposIndex->getPutMoneyInPopup()->getReasonInput()->setValue($reasonTransaction);
        }
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        sleep(2);
        $this->webposIndex->getSessionInfo()->getPutMoneyInButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue($pushMoneyIn);
        if ($reasonTransaction != null) {
            $this->webposIndex->getPutMoneyInPopup()->getReasonInput()->setValue($reasonTransaction);
        }
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        sleep(2);
        self::assertFalse(
            $this->webposIndex->getPutMoneyInPopup()->isVisible(),
            'The popup should have not visible.'
        );
        self::assertEquals(
            '$'.$amountValue.'.00',
            $this->webposIndex->getSessionInfo()->getAddTransactionAmount()->getText(),
            'The transaction amount is wrong. It have to be '.$amountValue
        );
        $transaction = $realOpeningAmount - $amountValue + $pushMoneyIn;
        self::assertEquals(
            '$'.$transaction.'.00',
            $this->webposIndex->getSessionInfo()->getTheoretialClosingBalance()->getText(),
            'The transaction amount is wrong. It have to be $'.$openingAmount - $amountValue.'.00'
        );

        $transactionAmount = '-$' . $transaction . '.00';
        self::assertEquals(
            $transactionAmount,
            $this->webposIndex->getSessionInfo()->getDifferentValue()->getText(),
            'The transaction amount is wrong. It have to be -$' . $transaction . '.00'
        );
        $this->webposIndex->getSessionInfo()->getAddTransactionButton()->click();
        self::assertTrue(
            $this->webposIndex->getCashActivitiesPopup()->isVisible(),
            'The Cash Activities Popup is not visible.'
        );
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