<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/10/2017
 * Time: 14:15
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceConfirmPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoicePopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryInvoiceTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertInvoicePopupDisplay
	 */
	protected $assertInvoicePopupDisplay;

	/**
	 * @var AssertInvoiceConfirmPopupDisplay
	 */
	protected $assertInvoiceConfirmPopupDisplay;

	public function __inject(
		WebposIndex $webposIndex,
		AssertInvoicePopupDisplay $assertInvoicePopupDisplay,
		AssertInvoiceConfirmPopupDisplay $assertInvoiceConfirmPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertInvoicePopupDisplay = $assertInvoicePopupDisplay;
		$this->assertInvoiceConfirmPopupDisplay = $assertInvoiceConfirmPopupDisplay;
	}

	public function test(
		Staff $staff,
		$products,
		$addDiscount100 = false,
		$shipped = false,
		$paid = true,
		$placeOrderPayment = 'cash',
		$paidAmount = null,
		$createShipment = false,
		$takePayment = true,
		$paymentMethod = 'Web POS - Cash In',
		$takePaymentAmount = null,
		$comment = null,
		$sendEmail = false,
		$action = 'submit',
		$confirmAction = 'ok',
		$expectStatus = null
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

		//Create Shipment
		if ($createShipment) {
			$shipText = 'Ship';
			$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
			self::assertTrue(
				$this->webposIndex->getOrdersHistory()->getAction($shipText)->isVisible(),
				'Order History - Invoice - Ship Action is missed'
			);

			$this->webposIndex->getOrdersHistory()->getAction($shipText)->click();
			$this->webposIndex->getOrdersHistory()->getShipSummitButton()->click();
			$this->webposIndex->getModal()->getOkButton()->click();
			sleep(15);
		}

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
				$result['total-paid'] += $takePaymentAmount;
//				$result['remain-money'] = (float)$result['remain-money'] - (float)$takePaymentAmount;
			}
			$this->webposIndex->getOrdersHistory()->getTakePaymentSubmitButton()->click();
			$this->webposIndex->getModal()->getOkButton()->click();
			sleep(15);
		}

		// Create Invoice
		$this->webposIndex->getOrdersHistory()->getInvoiceButton()->click();
		sleep(1);

		// Assert Invoice Popup display
		$this->assertInvoicePopupDisplay->processAssert($this->webposIndex, $products);

		sleep(1);

		foreach ($products as $product) {
			if (isset($product['invoice_qty'])) {
				$this->webposIndex->getOrdersHistory()->getInvoiceItemQtyToInvoiceInput($product['name'])->setValue($product['invoice_qty']);
			}
		}

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

		return [
			'orderId' => $orderId,
			'result' => $result,
			'expectStatus' => $expectStatus
		];
	}
}