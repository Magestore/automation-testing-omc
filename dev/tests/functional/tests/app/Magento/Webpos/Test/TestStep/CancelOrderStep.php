<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 09:41
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\ConfirmPopup\AssertConfimationPopupDisplay;
use Magento\Webpos\Test\Page\WebposIndex;

class CancelOrderStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertConfimationPopupDisplay
     */
    protected $assertConfimationPopupDisplay;

    /**
     * @var AssertCancelPopupDisplay
     */
    protected $assertCancelPopupDisplay;

    protected $comment;
    protected $action;
    protected $confirmAction;


    public function __construct(
        WebposIndex $webposIndex,
        AssertConfimationPopupDisplay $assertConfimationPopupDisplay,
        AssertCancelPopupDisplay $assertCancelPopupDisplay,
        $comment = null,
        $action = 'save',
        $confirmAction = 'ok'
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertConfimationPopupDisplay = $assertConfimationPopupDisplay;
        $this->assertCancelPopupDisplay = $assertCancelPopupDisplay;
        $this->comment = $comment;
        $this->action = $action;
        $this->confirmAction = $confirmAction;
    }

    /**
     * @return mixed|void
     */
    public function run()
    {
        if (!$this->webposIndex->getOrderHistoryAddCancelComment()->isVisible()) {
            $text = 'Cancel';
            if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
                $this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
            }
            $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction($text)->click();
        }

        $this->webposIndex->getOrderHistoryContainer()->waitForCancelPopupIsVisible();

        // Assert Cancel Popup display
        $this->assertCancelPopupDisplay->processAssert($this->webposIndex);


        if (isset($this->comment)) {
            $this->comment = str_replace('%isolation%', rand(1, 9999999), $this->comment);
            while (!$this->webposIndex->getOrderHistoryAddCancelComment()->isVisible()) {
                $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Cancel')->click();
                sleep(0.5);
            }
            $this->webposIndex->getOrderHistoryAddCancelComment()->getCommentInput()->setValue($this->comment);
        }

        if (strcmp($this->action, 'cancel') == 0) {
            $this->webposIndex->getOrderHistoryAddCancelComment()->getCancelButton()->click();
        } elseif (strcmp($this->action, 'save') == 0) {

            $this->webposIndex->getOrderHistoryAddCancelComment()->getSaveButton()->click();

            $this->webposIndex->getMsWebpos()->waitForModalPopup();
            // Assert Confirmation Popup
            $message = 'Are you sure you want to cancel this order?';
            $this->assertConfimationPopupDisplay->processAssert($this->webposIndex, $message);


            if (strcmp($this->confirmAction, 'close') == 0) {
                $this->webposIndex->getModal()->getCloseButton()->click();
            } elseif (strcmp($this->confirmAction, 'cancel') == 0) {
                $this->webposIndex->getModal()->getCancelButton()->click();
            } elseif (strcmp($this->confirmAction, 'ok') == 0) {
                $this->webposIndex->getModal()->getOkButton()->click();
            }
        }
        sleep(1);
    }
}