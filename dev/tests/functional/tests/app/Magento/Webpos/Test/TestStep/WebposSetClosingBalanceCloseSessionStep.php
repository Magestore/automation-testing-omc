<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 15/05/2018
 * Time: 15:34
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSetClosingBalanceCloseSessionStep
 * @package Magento\Webpos\Test\TestStep
 */
class WebposSetClosingBalanceCloseSessionStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;
    /**
     * @var Denomination
     */
    protected $denomination;
    protected $denominationNumberCoin;

    public function __construct(
        WebposIndex $webposIndex,
        $denomination = null,
        $denominationNumberCoin = '0'
    )
    {
        $this->webposIndex = $webposIndex;
        $this->denomination = $denomination;
        $this->denominationNumberCoin = $denominationNumberCoin;
    }

    public function run()
    {
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->getSessionManagement();
        sleep(1);
        // Set closing balance
        $this->webposIndex->getSessionShift()->getSetClosingBalanceButton()->click();
        sleep(1);
        if ($this->denomination != null) {
            $this->webposIndex->getSessionSetClosingBalancePopup()->setCoinBillValue($this->denomination->getDenominationName());
        }
        $this->webposIndex->getSessionSetClosingBalancePopup()->getColumnNumberOfCoinsAtRow(2)->setValue($this->denominationNumberCoin);
        $this->webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->click();
        sleep(1);

        if ($this->webposIndex->getSessionConfirmModalPopup()->isVisible()) {
            $this->webposIndex->getSessionConfirmModalPopup()->getOkButton()->click();
            $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupVisible();
            $this->webposIndex->getSessionSetReasonPopup()->getReason()->setValue('Magento');
            sleep(1);
            $this->webposIndex->getSessionSetReasonPopup()->getConfirmButton()->click();
            $this->webposIndex->getSessionSetClosingBalanceReason()->waitSetReasonPopupNotVisible();
        }
        // End session
        $this->webposIndex->getSessionShift()->getButtonEndSession()->click();
        $this->webposIndex->getSessionShift()->waitBtnCloseSessionNotVisible();
    }
}