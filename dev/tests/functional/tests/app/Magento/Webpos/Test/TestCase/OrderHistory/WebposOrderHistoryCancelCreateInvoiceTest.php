<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/10/2017
 * Time: 14:11
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryCancelCreateInvoiceTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;


	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		$products,
		$shipped = false,
		$paid = true
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

		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$this->webposIndex->getCheckoutPage()->selectPayment();
		$this->webposIndex->getCheckoutPage()->setPaidAmount(0);

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


		// Take Payment
		$this->webposIndex->getOrdersHistory()->getTakePaymentButton()->click();
		$paymentMethodText = 'Web POS - Cash In';
		$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($paymentMethodText)->click();
		sleep(1);
		$this->webposIndex->getOrdersHistory()->getTakePaymentSubmitButton()->click();
		$this->webposIndex->getModal()->getOkButton()->click();
		/////////

		// Create Invoice
		$this->webposIndex->getOrdersHistory()->getInvoiceButton()->click();
		sleep(1);
		/*
		 * error input value
		 * */
		foreach ($products as $product) {
			if (!empty($product['invoice_qty'])) {
				$this->webposIndex->getOrdersHistory()->getInvoiceItemQtyToInvoiceInput($product['name'])->setValue($product['invoice_qty']);
			}
		}
		$this->webposIndex->getOrdersHistory()->getInvoiceSubmitButton()->click();
		$this->webposIndex->getModal()->getOkButton()->click();
		//////////////////

		return [
			'orderId' => $orderId
		];
	}
}