<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/23/18
 * Time: 3:40 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckValidateAmountFieldSM24Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * Settings [Need to create session before working] = Yes
 * 1. Login webpos by an account who has opening session permission
 * 2. Click to show left menu
 * 3. Click on [Session management] menu > Open a new session successfully with opening amount = 100"
 * Steps
 * "1. Click on [Take money out] button
 * 2. Input positive number into [Amount] field (Ex: 20)
 * 3. Click on [Done] button
 * 4. Click on [-Transactions] "
 */
class WebposCheckValidateAmountFieldSM24Test extends Injectable
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
    public function test(
        $dataConfig,
        Denomination $denomination,
        $dataConfigToNo,
        $openingAmount,
        $amountValue,
        $realOpeningAmount,
        $reasonTransaction
    )
    {
        $this->dataConfigToNo = $dataConfigToNo;
        //Set Create Session Before Working to Yes
        $denomination->persist();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfig]
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep',
            [
                'openingAmountStatus' => true,
                'denomination' => $denomination,
                'denominationNumberCoin' => $openingAmount,
                'takeMoneyOutStatus' => true,
                'takeMoneyOutValue' => $amountValue
            ]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getMsWebpos()->waitForCMenuLoader();
        $this->webposIndex->getCMenu()->getSessionManagement();
        $this->webposIndex->getMsWebpos()->waitForSessionManagerLoader();

        self::assertFalse(
            $this->webposIndex->getPutMoneyInPopup()->isVisible(),
            'The popup should have not visible.'
        );
        self::assertEquals(
            '$' . $amountValue . '.00',
            $this->webposIndex->getSessionInfo()->getAddTransactionAmount()->getText(),
            'The transaction amount is wrong. It have to be ' . $amountValue
        );
        $transaction = $realOpeningAmount - $amountValue;
        self::assertEquals(
            '$' . $transaction . '.00',
            $this->webposIndex->getSessionInfo()->getTheoretialClosingBalance()->getText(),
            'The transaction amount is wrong. It have to be $' . $openingAmount - $amountValue . '.00'
        );
        if ($reasonTransaction != null) {
            $transactionAmount = '$' . $transaction . '.00';
        } else {
            $transactionAmount = '-$' . $transaction . '.00';
        }
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