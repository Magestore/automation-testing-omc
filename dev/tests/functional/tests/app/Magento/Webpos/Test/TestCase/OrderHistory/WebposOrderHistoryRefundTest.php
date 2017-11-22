<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/10/2017
 * Time: 07:54
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundConfirmPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundPopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryRefundTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertRefundPopupDisplay
	 */
	protected $assertRefundPopupDisplay;

	/**
	 * @var AssertRefundConfirmPopupDisplay
	 */
	protected $assertRefundConfirmPopupDisplay;

	public function __inject(
		WebposIndex $webposIndex,
		AssertRefundPopupDisplay $assertRefundPopupDisplay,
		AssertRefundConfirmPopupDisplay $assertRefundConfirmPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertRefundPopupDisplay = $assertRefundPopupDisplay;
		$this->assertRefundConfirmPopupDisplay = $assertRefundConfirmPopupDisplay;
	}

	public function test(
		Staff $staff,
		$products,
		$addDiscount100 = false,
		$shipped = false,
		$paid = true,
		$placeOrderPayment = 'cash',
		$paidAmount = null,
		$takePayment = true,
		$paymentMethod = 'Web POS - Cash In',
		$takePaymentAmount = null,
		$adjustRefund = null,
		$adjustFee = null,
		$comment = null,
		$sendEmail = false,
		$action = 'submit',
		$confirmAction = 'ok',
		$expectStatus = null,
		$hideAction = null,
		$totalRefunded = null
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		foreach ($products as $product) {
			for ($i = 0; $i < $product['qty']; $i++) {
				$this->webposIndex->getCheckoutPage()->search($product['name']);
			}
		}

		if ($addDiscount100) {
			$this->webposIndex->getCheckoutPage()->getAddDiscount()->click();
			self::assertTrue(
				$this->webposIndex->getCheckoutPage()->getAddDiscountPopup()->isVisible(),
				'Add discount popup is not showed'
			);
			$this->webposIndex->getCheckoutPage()->setDiscountPercent('100.00');
			$this->webposIndex->getCheckoutPage()->clickDiscountApplyButton();
		}

		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$result['total'] = $this->webposIndex->getCheckoutPage()->getTotal2();
		$result['total'] = substr($result['total'], 1);

		$result['total-paid'] = 0;
		if (!$addDiscount100) {
			$this->webposIndex->getCheckoutPage()->selectPayment($placeOrderPayment);
			sleep(1);
			if (isset($paidAmount)) {
				$this->webposIndex->getCheckoutPage()->setPaidAmount($paidAmount);
				$result['total-paid']+= $paidAmount;
			}
		}
		$this->webposIndex->getCheckoutPage()->getRemainMoney()->click();
		sleep(1);
		$result['remain-money'] = $this->webposIndex->getCheckoutPage()->getRemainMoney()->getText();
		$result['remain-money'] = substr($result['remain-money'], 1);

		$shippingCheckbox = $this->webposIndex->getCheckoutPage()->getShippingCheckbox();
		if ($shippingCheckbox->isVisible()) {
			if ($shipped != $this->webposIndex->getCheckoutPage()->isCheckboxChecked($shippingCheckbox)) {
				$shippingCheckbox->click();
			}
		}

		$paidCheckbox = $this->webposIndex->getCheckoutPage()->getPaidCheckbox();
		if ($paidCheckbox->isVisible()) {
			if ($paid != $this->webposIndex->getCheckoutPage()->isCheckboxChecked($paidCheckbox)) {
				$paidCheckbox->click();
			}
		}

		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();
		sleep(1);
		$orderId = $this->webposIndex->getCheckoutPage()->getOrderId();
		$orderId = substr($orderId, 1);

		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();

		// Get Product Stock Qty before refund
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(1);

		for ($i = 0; $i < sizeof($products); $i++) {
			$products[$i]['qty_before_refund'] = (int) $this->webposIndex->getManageStocks()->getQtyInputByName($products[$i]['name'])->getValue();
		}
		//////////////////////////////////////

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();

		sleep(1);
		$this->webposIndex->getOrdersHistory()->getFirstOrder()->click();

		while (strcmp($this->webposIndex->getOrdersHistory()->getStatus(), 'Not Sync') == 0) {}
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			"Order List is empty"
		);

		self::assertEquals(
			$orderId,
			$this->webposIndex->getOrdersHistory()->getOrderId(),
			'Order Id is wrong'
		);


		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getInvoiceButton()->isVisible(),
			'Order history - Invoice - Invoice button is not displayed'
		);

		//Take Payment
		if ($takePayment && !$addDiscount100) {
			$this->webposIndex->getOrdersHistory()->getTakePaymentButton()->click();

			self::assertTrue(
				$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($paymentMethod)->isVisible(),
				"Can't find payment method '".$paymentMethod."' in list"
			);
			$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($paymentMethod)->click();
			sleep(1);
			if (isset($takePaymentAmount)) {
				$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentInputBox($paymentMethod)->setValue($takePaymentAmount);
				$result['total-paid'] += $takePaymentAmount;
//				$result['remain-money'] = (float)$result['remain-money'] - (float)$takePaymentAmount;
			} else {
				$result['total-paid'] += (float) $this->webposIndex->getOrdersHistory()->getTakePaymentPaymentInputBox($paymentMethod)->getValue();
			}
			$this->webposIndex->getOrdersHistory()->getTakePaymentSubmitButton()->click();
			$this->webposIndex->getModal()->getOkButton()->click();
			sleep(10);
		}

		// Create Invoice
		$this->webposIndex->getOrdersHistory()->getInvoiceButton()->click();
		sleep(1);
		$this->webposIndex->getOrdersHistory()->getInvoiceSubmitButton()->click();
		$this->webposIndex->getModal()->getOkButton()->click();
		sleep(10);

		// Refund
		if (!$addDiscount100) {
			$refundText = 'Refund';
			$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
			self::assertTrue(
				$this->webposIndex->getOrdersHistory()->getAction($refundText)->isVisible(),
				'Order History - Refund - Refund Action is missed'
			);
			$this->webposIndex->getOrdersHistory()->getAction($refundText)->click();

			// Assert Refund Popup display
			$this->assertRefundPopupDisplay->processAssert($this->webposIndex, $products);

			sleep(1);

			foreach ($products as $product) {
				if (isset($product['refund_qty'])) {
					$this->webposIndex->getOrdersHistory()->getRefundItemQtyToRefundInput($product['name'])->setValue($product['refund_qty']);
				}

				if (isset($product['return_to_stock'])) {
					$returnToStockCheckbox = $this->webposIndex->getOrdersHistory()->getRefundItemReturnToStockCheckbox($product['name']);
					if ($product['return_to_stock'] != $returnToStockCheckbox->isSelected()) {
						$returnToStockCheckbox->click();
					}
				}
			}

			if (isset($comment)) {
				$comment = str_replace('%isolation%', rand(1, 9999999), $comment);
				$this->webposIndex->getOrdersHistory()->getRefundCommentBox()->setValue($comment);
			}

			$sendEmailCheckbox = $this->webposIndex->getOrdersHistory()->getRefundSendEmailCheckbox();
			if ($sendEmailCheckbox->isVisible()) {
				if ($sendEmail != $sendEmailCheckbox->isSelected()) {
					$sendEmailCheckbox->click();
				}
			}

			if (isset($adjustRefund)) {
				$this->webposIndex->getOrdersHistory()->getRefundAdjustRefundBox()->setValue($adjustRefund);
			}

			if (isset($adjustFee)) {
				$this->webposIndex->getOrdersHistory()->getRefundAdjustFee()->setValue($adjustFee);
			}

			if (strcmp($action, 'cancel') == 0) {
				$this->webposIndex->getOrdersHistory()->getRefundCancelButton()->click();
			} elseif (strcmp($action, 'submit') == 0) {

				$this->webposIndex->getOrdersHistory()->getRefundSubmitButton()->click();


				// Assert Confirmation Popup
				$this->assertRefundConfirmPopupDisplay->processAssert($this->webposIndex);

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
			'orderId' => $orderId,
			'products' => $products,
			'result' => $result,
			'expectStatus' => $expectStatus,
			'hideAction' => $hideAction,
			'totalRefunded' => $totalRefunded
		];
	}
}