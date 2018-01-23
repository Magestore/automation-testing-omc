<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/01/2018
 * Time: 16:54
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

class CreateInvoiceInOrderHistoryStep implements TestStepInterface
{

	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;
	protected $products;
	protected $comment;
	protected $sendEmail;
	protected $action;
	protected $confirmAction;

	/**
	 * CreateInvoiceInOrderHistoryStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $products
	 * @param null $comment
	 * @param bool $sendEmail
	 * @param string $action
	 * @param string $confirmAction
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$products,
		$comment = null,
		$sendEmail = false,
		$action = 'submit',
		$confirmAction = 'ok'
	)
	{
		$this->webposIndex = $webposIndex;
		$this->products = $products;
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
		if (!$this->webposIndex->getOrderHistoryInvoice()->isVisible()) {
			$this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
			$this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
		}

		foreach ($this->products as $item) {
			if (isset($item['invoiceQty'])) {
				$this->webposIndex->getOrderHistoryInvoice()->getItemQtyToInvoiceInput($item['product']->getName())->setValue($item['invoiceQty']);
			}
		}

		if (isset($this->comment)) {
			$this->comment = str_replace('%isolation%', rand(1, 9999999), $this->comment);
			$this->webposIndex->getOrderHistoryInvoice()->getCommentInput()->setValue($this->comment);
		}

		$sendEmailCheckbox = $this->webposIndex->getOrderHistoryInvoice()->getSendEmailCheckbox();
		if ($sendEmailCheckbox->isVisible()) {
			if ($this->sendEmail != $this->webposIndex->getOrderHistoryInvoice()->getSendEmailCheckbox()->isSelected()) {
				$sendEmailCheckbox->click();
			}
		}

		if (strcmp($this->action, 'cancel') == 0) {
			$this->webposIndex->getOrderHistoryInvoice()->getCancelButton()->click();
		} elseif (strcmp($this->action, 'submit') == 0) {

			$this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();


			// Assert Confirmation Popup
//			$this->assertInvoiceConfirmPopupDisplay->processAssert($this->webposIndex);

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