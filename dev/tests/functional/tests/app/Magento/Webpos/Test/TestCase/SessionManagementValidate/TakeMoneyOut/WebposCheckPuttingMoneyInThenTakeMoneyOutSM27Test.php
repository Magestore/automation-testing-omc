<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/23/18
 * Time: 5:21 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckPuttingMoneyInThenTakeMoneyOutSM27Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * "Precondition: Settings [Need to create session before working] = Yes
 * 1. Login webpos by an account who has opening session permission
 * 2. Click to show left menu
 * 3. Click on [Session management] menu > Open a new session successfully"
 * Steps
 * "1. Click on [Put money in] button > put in 100
 * 2. Click on [Take money out] button > take out 20"
 */
class WebposCheckPuttingMoneyInThenTakeMoneyOutSM27Test extends Injectable
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
    public function test($dataConfig, $dataConfigToNo, $reasonTransaction, $takeMoneyOut, $pushMoneyIn)
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
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
        sleep(1);
        $this->webposIndex->getSessionInfo()->getPutMoneyInButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue($pushMoneyIn);
        if ($reasonTransaction != null) {
            $this->webposIndex->getPutMoneyInPopup()->getReasonInput()->setValue($reasonTransaction);
        }
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        sleep(2);
        $this->webposIndex->getSessionInfo()->waitForTakeMoneyOutButton();
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue($takeMoneyOut);
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
            '$' . $pushMoneyIn . '.00',
            $this->webposIndex->getSessionInfo()->getAddTransactionTotal()->getText(),
            'The transaction amount is wrong. It have to be $' . $pushMoneyIn . '.00'
        );
        self::assertEquals(
            '$' . $takeMoneyOut . '.00',
            $this->webposIndex->getSessionInfo()->getAddTransactionAmount()->getText(),
            'The transaction amount is wrong. It have to be ' . $takeMoneyOut
        );
        $different = $pushMoneyIn - $takeMoneyOut;
        $transactionAmount = '-$' . $different . '.00';
        self::assertEquals(
            $transactionAmount,
            $this->webposIndex->getSessionInfo()->getDifferentValue()->getText(),
            'The transaction amount is wrong. It have to be -$' . $transactionAmount . '.00'
        );
        self::assertEquals(
            '$' . $different . '.00',
            $this->webposIndex->getSessionInfo()->getTheoretialClosingBalance()->getText(),
            'The transaction amount is wrong. It have to be ' . $different
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