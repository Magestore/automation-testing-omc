<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 10/05/2018
 * Time: 10:47
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOpenSessionStep
 * @package Magento\Webpos\Test\TestStep
 */
class WebposOpenSessionStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var bool
     */
    protected $openingAmountStatus;
    /**
     * @var Denomination
     */
    protected $denomination;
    protected $denominationNumberCoin;

    /**
     * @var bool
     */
    protected $putMoneyInStatus;
    protected $putMoneyInValue;

    /**
     * @var bool
     */
    protected $takeMoneyOutStatus;
    protected $takeMoneyOutValue;

    public function __construct(
        WebposIndex $webposIndex,
        $openingAmountStatus = false,
        Denomination $denomination = null,
        $denominationNumberCoin = null,
        $putMoneyInStatus = false,
        $putMoneyInValue = 0,
        $takeMoneyOutStatus = false,
        $takeMoneyOutValue = 0
    ) {
        $this->webposIndex = $webposIndex;
        $this->openingAmountStatus = $openingAmountStatus;
        $this->denomination = $denomination;
        $this->denominationNumberCoin = $denominationNumberCoin;
        $this->putMoneyInStatus = $putMoneyInStatus;
        $this->putMoneyInValue = $putMoneyInValue;
        $this->takeMoneyOutStatus = $takeMoneyOutStatus;
        $this->takeMoneyOutValue = $takeMoneyOutValue;
    }

    public function run()
    {
        // Open session
        $time = time();
        $timeAfter = $time + 3;
        while (!$this->webposIndex->getOpenSessionPopup()->isVisible()
            && $time < $timeAfter) {
            $time = time();
        }
        if ($this->webposIndex->getOpenSessionPopup()->isVisible()) {
            $this->webposIndex->getOpenSessionPopup()->waitLoader();
            $this->webposIndex->getOpenSessionPopup()->waitUntilForOpenSessionButtonVisible();

            if ($this->openingAmountStatus)
            {
                $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($this->denomination->getDenominationName());
                $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue($this->denominationNumberCoin);
            }

            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButtonElement()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
            $this->webposIndex->getSessionShift()->waitBtnCloseSessionVisible();

            if($this->putMoneyInStatus)
            {
                $this->webposIndex->getSessionShift()->getPutMoneyInButton()->click();
                $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-make-adjustment"]');
                $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->click();
                $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->setValue($this->putMoneyInValue);
                $this->webposIndex->getSessionMakeAdjustmentPopup()->getDoneButton()->click();
                $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-make-adjustment"]');
            }

            if($this->takeMoneyOutStatus)
            {
                $this->webposIndex->getSessionShift()->getTakeMoneyOutButton()->click();
                $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-make-adjustment"]');
                $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->click();
                $this->webposIndex->getSessionMakeAdjustmentPopup()->getAmount()->setValue($this->takeMoneyOutValue);
                $this->webposIndex->getSessionMakeAdjustmentPopup()->getDoneButton()->click();
                $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-make-adjustment"]');
            }

            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
            sleep(1);
        }
    }
}