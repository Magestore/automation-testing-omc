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
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\Adminhtml\DenominationIndex;
use Magento\Webpos\Test\Page\Adminhtml\DenominationNews;
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
     * Webpos Denomination Index page.
     *
     * @var DenominationIndex
     */
    private $denominationIndex;
    /**
     * New Denominaiton Group page.
     *
     * @var DenominationNews
     */
    private $denominationNews;

    /**
     * @param WebposIndex $webposIndex
     * @param DenominationIndex $denominationIndex
     * @param DenominationNews $denominationNews
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        DenominationIndex $denominationIndex,
        DenominationNews $denominationNews
    )
    {
        $this->webposIndex = $webposIndex;
        $this->denominationIndex = $denominationIndex;
        $this->denominationNews = $denominationNews;
    }

    /**
     * @param Denomination $denomination
     * @param $dataConfig
     * @param $dataConfigToNo
     * @param $amountValue
     * @param $openingAmount
     * @return array
     */
    public function test(Denomination $denomination=null, $dataConfig, $testCaseID, $dataConfigToNo, $amountValue=null, $openingAmount=null)
    {
        if ($testCaseID == 'SM22') {
            // Steps Create Denomination
            $this->denominationIndex->open();
            $this->denominationIndex->getPageActionsBlock()->addNew();
            $this->denominationNews->getDenominationsForm()->fill($denomination);
            $this->denominationNews->getFormPageActions()->save();
        }
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

        $this->webposIndex->getOpenSessionPopup()->waitNumberOfCoinsBills();
        $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue($openingAmount);
        $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        $this->webposIndex->getSessionInfo()->waitForTakeMoneyOutButton();
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        if ($testCaseID == 'SM21' || $testCaseID == 'SM22') {
            $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue($amountValue);
        }
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
    }
}