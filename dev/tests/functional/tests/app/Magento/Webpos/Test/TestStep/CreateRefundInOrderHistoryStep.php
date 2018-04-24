<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 10/01/2018
 * Time: 11:09
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

class CreateRefundInOrderHistoryStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;
	protected $products;
	protected $adjustRefund;
	protected $refundShipping;
	protected $adjustFee;
	protected $comment;
	protected $sendEmail;
	protected $action;
	protected $confirmAction;


	/**
	 * CreateRefundInOrderHistoryStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $products
	 * @param null $adjustRefund
	 * @param null $adjustFee
	 * @param null $comment
	 * @param bool $sendEmail
	 * @param string $action
	 * @param string $confirmAction
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$products,
		$adjustRefund = null,
		$refundShipping = null,
		$adjustFee = null,
		$comment = null,
		$sendEmail = false,
		$action = 'submit',
		$confirmAction = 'ok'
	)
	{
		$this->webposIndex = $webposIndex;
		$this->products = $products;
		$this->adjustRefund = $adjustRefund;
		$this->refundShipping = $refundShipping;
		$this->adjustFee = $adjustFee;
		$this->comment = $comment;
		$this->sendEmail = $sendEmail;
		$this->action = $action;
		$this->confirmAction = $confirmAction;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		if (!$this->webposIndex->getOrderHistoryRefund()->isVisible()) {
			$refundText = 'Refund';
			if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
				$this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
			}
			sleep(3);
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getAction($refundText)->click();
            sleep(2);
		}

//		// Assert Refund Popup display
//		$this->assertRefundPopupDisplay->processAssert($this->webposIndex, $products);

		$this->webposIndex->getOrderHistoryContainer()->waitForRefundPopupIsVisible();

		foreach ($this->products as $item) {
			if (isset($item['refundQty'])) {
				$this->webposIndex->getOrderHistoryRefund()->getItemQtyToRefundInput($item['product']->getName())->setValue($item['refundQty']);
			}

			if (isset($item['returnToStock'])) {
				$returnToStockCheckbox = $this->webposIndex->getOrderHistoryRefund()->getItemReturnToStockCheckbox($item['product']->getName());
				if ($item['returnToStock'] != $returnToStockCheckbox->isSelected()) {
					$returnToStockCheckbox->click();
				}
			}
		}

		if (isset($this->comment)) {
			$this->comment = str_replace('%isolation%', rand(1, 9999999), $this->comment);
			$this->webposIndex->getOrderHistoryRefund()->getCommentBox()->setValue($this->comment);
		}

		$sendEmailCheckbox = $this->webposIndex->getOrderHistoryRefund()->getSendEmailCheckbox();
		if ($sendEmailCheckbox->isVisible()) {
			if ($this->sendEmail != $sendEmailCheckbox->isSelected()) {
				$sendEmailCheckbox->click();
			}
		}

		if (isset($this->adjustRefund)) {
			$this->webposIndex->getOrderHistoryRefund()->getAdjustRefundBox()->setValue($this->adjustRefund);
		}

		if (isset($this->refundShipping)) {
			if ($this->webposIndex->getOrderHistoryRefund()->getRefundShipping()->isVisible()) {
				$this->webposIndex->getOrderHistoryRefund()->getRefundShipping()->setValue($this->refundShipping);
			}
		}

		if (isset($this->adjustFee)) {
			$this->webposIndex->getOrderHistoryRefund()->getAdjustFee()->setValue($this->adjustFee);
		}

		if (strcmp($this->action, 'cancel') == 0) {
            sleep(2);
			$this->webposIndex->getOrderHistoryRefund()->getCancelButton()->click();
		} elseif (strcmp($this->action, 'submit') == 0) {

			$this->webposIndex->getOrderHistoryRefund()->getSubmitButton()->click();
            sleep(2);
			$this->webposIndex->getMsWebpos()->waitForModalPopup();
			if (strcmp($this->confirmAction, 'close') == 0) {
				$this->webposIndex->getModal()->getCloseButton()->click();
			} elseif (strcmp($this->confirmAction, 'cancel') == 0) {
				$this->webposIndex->getModal()->getCancelButton()->click();
			} elseif (strcmp($this->confirmAction, 'ok') == 0) {
				$this->webposIndex->getModal()->getOkButton()->click();
			}
		}
	}
}