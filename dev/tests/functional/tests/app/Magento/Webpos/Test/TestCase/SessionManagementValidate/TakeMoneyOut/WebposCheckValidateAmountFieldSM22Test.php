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
 * Class WebposCheckValidateAmountFieldSM22Test
 * @package Magento\Webpos\Test\TestCase\SessionManagementValidate\TakeMoneyOut
 * SM22
 *  Precondition: Settings [Need to create session before working] = Yes
 * 1. Login webpos by an account who has opening session permission
 * 2. Click to show left menu
 * 3. Click on [Session management] menu > Open a new session successfully  with opening amount = 100"
 * SM22 - Steps:
 * 1. Click on [Take money out] button
 * 2. Input negative number into [Amount] field (Ex: -123)
 * 3. Click on [Done] button"
 */
class WebposCheckValidateAmountFieldSM22Test extends Injectable
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
     * @param Denomination|null $denomination
     * @param $dataConfig
     * @param $testCaseID
     * @param $dataConfigToNo
     * @param null $amountValue
     * @param null $openingAmount
     */
    public function test(Denomination $denomination = null, $dataConfig, $testCaseID, $dataConfigToNo, $amountValue = null, $openingAmount = null)
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
        $this->webposIndex->getSessionInfo()->getTakeMoneyOutButton()->click();
        $this->webposIndex->getPutMoneyInPopup()->waitForBtnCancel();
        $this->webposIndex->getPutMoneyInPopup()->getAmountInput()->setValue($amountValue);
        $this->webposIndex->getPutMoneyInPopup()->getDoneButton()->click();
        //Assert assert Webpos Check Validate Amount Field
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