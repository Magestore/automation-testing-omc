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

class WebposOpenSessionStep implements TestStepInterface
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
        Denomination $denomination = null,
        $denominationNumberCoin = null
    )
    {
        $this->webposIndex = $webposIndex;
        $this->denomination = $denomination;
        $this->denominationNumberCoin = $denominationNumberCoin;
    }

    public function run()
    {
        // Open session
        $time = time();
        $timeAfter = $time + 5;
        while (!$this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()
            && $time < $timeAfter) {
            $time = time();
        }
        if ($this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->isVisible()) {
            $this->webposIndex->getOpenSessionPopup()->waitForElementNotVisible('.indicator[data-bind="visible:loading"]');

            if ($this->denomination && $this->denominationNumberCoin) {
                $this->webposIndex->getOpenSessionPopup()->setCoinBillValue($this->denomination->getDenominationName());
                $this->webposIndex->getOpenSessionPopup()->getNumberOfCoinsBills()->setValue($this->denominationNumberCoin);
            }

            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-open-shift"]');
            sleep(2);
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
            sleep(1);
            if ($this->denomination && $this->denominationNumberCoin) {
                $openAmount = $this->denomination->getDenominationValue() * $this->denominationNumberCoin;
                return [
                    'openAmount' => $openAmount
                ];
            }
        }
    }
}