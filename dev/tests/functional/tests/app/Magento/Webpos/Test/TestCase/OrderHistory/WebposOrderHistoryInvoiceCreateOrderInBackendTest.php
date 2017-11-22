<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 19/10/2017
 * Time: 16:10
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceConfirmPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoicePopupDisplay;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryInvoiceCreateOrderInBackendTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var OrderInjectable
	 */
	protected $order;

	/**
	 * @var AssertInvoicePopupDisplay
	 */
	protected $assertInvoicePopupDisplay;

	/**
	 * @var AssertInvoiceConfirmPopupDisplay
	 */
	protected $assertInvoiceConfirmPopupDisplay;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	public function __inject(
		WebposIndex $webposIndex,
		AssertInvoicePopupDisplay $assertInvoicePopupDisplay,
		AssertInvoiceConfirmPopupDisplay $assertInvoiceConfirmPopupDisplay,
		AssertItemUpdateSuccess $assertItemUpdateSuccess
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertInvoicePopupDisplay = $assertInvoicePopupDisplay;
		$this->assertInvoiceConfirmPopupDisplay = $assertInvoiceConfirmPopupDisplay;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
	}

	public function test(
		OrderInjectable $order,
		Staff $staff,
		$takePayment = true,
		$paymentMethod = 'Web POS - Cash In',
		$takePaymentAmount = null,
		$canCreateInvoice = true,
		$comment = null,
		$sendEmail = false,
		$action = 'submit',
		$confirmAction = 'ok',
		$expectStatus = null
	)
	{
		$this->order = $order;
		$this->order->persist();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		} else {
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->synchronization();
			sleep(1);
			$itemText = 'Order';
			$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();
			$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText);
		}


		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();

		sleep(2);
		$this->webposIndex->getOrdersHistory()->getFirstOrder()->click();

		while (strcmp($this->webposIndex->getOrdersHistory()->getStatus(), 'Not Sync') == 0) {
		}
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			"Order List is empty"
		);

		//Take Payment
		if ($takePayment) {
			$this->webposIndex->getOrdersHistory()->getTakePaymentButton()->click();

			self::assertTrue(
				$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($paymentMethod)->isVisible(),
				"Can't find payment method '".$paymentMethod."' in list"
			);
			$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($paymentMethod)->click();
			sleep(1);
			if (isset($takePaymentAmount)) {
				$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentInputBox($paymentMethod)->setValue($takePaymentAmount);
			}
			$this->webposIndex->getOrdersHistory()->getTakePaymentSubmitButton()->click();
			$this->webposIndex->getModal()->getOkButton()->click();
			sleep(15);
		}

		// Create Invoice
		$this->webposIndex->getOrdersHistory()->getInvoiceButton()->click();
		if ($canCreateInvoice) {
			sleep(1);

			$productList = $this->order->getEntityId()['products'];

			foreach ($productList as $product) {
				$products[] = [
					'name' => $product->getName(),
					'qty' => $product->getCheckoutData()['qty']
				];
			}
			// Assert Invoice Popup display
			$this->assertInvoicePopupDisplay->processAssert($this->webposIndex, $products);

			if (isset($comment)) {
				$comment = str_replace('%isolation%', rand(1, 9999999), $comment);
				$this->webposIndex->getOrdersHistory()->getInvoiceCommentInput()->setValue($comment);
			}

			$sendEmailCheckbox = $this->webposIndex->getOrdersHistory()->getInvoiceSendEmailCheckbox();
			if ($sendEmailCheckbox->isVisible()) {
				if ($sendEmail != $this->webposIndex->getOrdersHistory()->getInvoiceSendEmailCheckbox()->isSelected()) {
					$sendEmailCheckbox->click();
				}
			}

			if (strcmp($action, 'cancel') == 0) {
				$this->webposIndex->getOrdersHistory()->getInvoiceCancelButton()->click();
			} elseif (strcmp($action, 'submit') == 0) {

				$this->webposIndex->getOrdersHistory()->getInvoiceSubmitButton()->click();


				// Assert Confirmation Popup
				$this->assertInvoiceConfirmPopupDisplay->processAssert($this->webposIndex);

				if (strcmp($confirmAction, 'close') == 0) {
					$this->webposIndex->getModal()->getCloseButton()->click();
				} elseif (strcmp($confirmAction, 'cancel') == 0) {
					$this->webposIndex->getModal()->getCancelButton()->click();
				} elseif (strcmp($confirmAction, 'ok') == 0) {
					$this->webposIndex->getModal()->getOkButton()->click();
				}
			}
		}

		return [
			'orderId' => $order->getId(),
			'expectStatus' => $expectStatus
		];
	}
}