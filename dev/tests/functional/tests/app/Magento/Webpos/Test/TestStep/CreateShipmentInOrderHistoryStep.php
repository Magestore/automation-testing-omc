<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 13:40
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

class CreateShipmentInOrderHistoryStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;
	protected $products;
	protected $comment;
	protected $trackNumber;
	protected $sendEmail;
	protected $action;
	protected $confirmAction;


	public function __construct(
		WebposIndex $webposIndex,
		$products,
		$comment = null,
		$trackNumber = null,
		$sendEmail = false,
		$action = 'submit',
		$confirmAction = 'ok'
	)
	{
		$this->webposIndex = $webposIndex;
		$this->products = $products;
		$this->comment = $comment;
		$this->trackNumber = $trackNumber;
		$this->sendEmail = $sendEmail;
		$this->action = $action;
		$this->confirmAction = $confirmAction;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		if (!$this->webposIndex->getOrderHistoryShipment()->isVisible()) {
			$text = 'Ship';
			if (!$this->webposIndex->getOrderHistoryContainer()->getActionsBox()->isVisible()) {
				$this->webposIndex->getOrderHistoryOrderViewHeader()->getMoreInfoButton()->click();
			}
			$this->webposIndex->getOrderHistoryOrderViewHeader()->getAction($text)->click();
		}

//		// Assert Refund Popup display
//		$this->assertRefundPopupDisplay->processAssert($this->webposIndex, $products);

		$this->webposIndex->getOrderHistoryContainer()->waitForShipmentPopupIsVisible();

		foreach ($this->products as $item) {
			if (isset($item['shipQty'])) {
				$this->webposIndex->getOrderHistoryShipment()->getQtyToShipInput($item['product']->getName())->setValue($item['shipQty']);
			}
		}

		if (isset($this->comment)) {
			$this->comment = str_replace('%isolation%', rand(1, 9999999), $this->comment);
			$this->webposIndex->getOrderHistoryShipment()->getShipmentComment()->setValue($this->comment);
		}

		if (isset($this->trackNumber)) {
			$this->trackNumber = str_replace('%isolation%', rand(1, 9999999), $this->trackNumber);
			$this->webposIndex->getOrderHistoryShipment()->getTrackNumber()->setValue($this->trackNumber);
		}

		$sendEmailCheckbox = $this->webposIndex->getOrderHistoryShipment()->getSendMailCheckbox();
		if ($sendEmailCheckbox->isVisible()) {
			if ($this->sendEmail != $sendEmailCheckbox->isSelected()) {
				$sendEmailCheckbox->click();
			}
		}

		if (strcmp($this->action, 'cancel') == 0) {
			$this->webposIndex->getOrderHistoryShipment()->getCancelButton()->click();
		} elseif (strcmp($this->action, 'submit') == 0) {
		    $this->webposIndex->getOrderHistoryShipment()->waitForElementVisible('#shipment-popup-form > div.modal-body > div.actions > button.btn-cl-cfg-active');
			$this->webposIndex->getOrderHistoryShipment()->getSubmitButton()->click();

			$this->webposIndex->getMsWebpos()->waitForModalPopup();
//			// Assert Confirmation Popup
//			$this->assertRefundConfirmPopupDisplay->processAssert($this->webposIndex);

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