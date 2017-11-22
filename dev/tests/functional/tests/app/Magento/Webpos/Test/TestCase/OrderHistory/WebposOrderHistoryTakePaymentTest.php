<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 09:39
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\TakePayment\AssertTakePaymentConfirmPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\TakePayment\AssertTakePaymentPopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryTakePaymentTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertTakePaymentPopupDisplay
	 */
	protected $assertTakePaymentPopupDisplay;

	/**
	 * @var AssertTakePaymentConfirmPopupDisplay
	 */
	protected $assertTakePaymentConfirmPopupDisplay;

	public function __inject(
		WebposIndex $webposIndex,
		AssertTakePaymentPopupDisplay $assertTakePaymentPopupDisplay,
		AssertTakePaymentConfirmPopupDisplay $assertTakePaymentConfirmPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertTakePaymentPopupDisplay = $assertTakePaymentPopupDisplay;
		$this->assertTakePaymentConfirmPopupDisplay = $assertTakePaymentConfirmPopupDisplay;
	}

	public function test(
		Staff $staff,
		$product,
		$shipped = false,
		$placeOrderPayment = 'cash',
		$paidAmount = null,
		$paymentMethod = null,
		$action = 'submit',
		$confirmAction = 'ok'
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

		$this->webposIndex->getCheckoutPage()->search($product['sku']);

		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$result['total'] = $this->webposIndex->getCheckoutPage()->getTotal2();
		$result['total'] = substr($result['total'], 1);

		$this->webposIndex->getCheckoutPage()->selectPayment($placeOrderPayment);
		sleep(1);
		$result['total-paid'] = 0;
		if (isset($paidAmount)) {
			$this->webposIndex->getCheckoutPage()->setPaidAmount($paidAmount);
			$result['total-paid']+= $paidAmount;
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
			$this->webposIndex->getOrdersHistory()->getTakePaymentButton()->isVisible(),
			'Order history - Take Payment - take payment button is not displayed'
		);

		// Take Payment
		$this->webposIndex->getOrdersHistory()->getTakePaymentButton()->click();
		sleep(1);

		// Assert Take Payment Popup display
		$this->assertTakePaymentPopupDisplay->processAssert($this->webposIndex);

		if (strcmp($action, 'cancel') == 0) {
			$this->webposIndex->getOrdersHistory()->getTakePaymentCancelButton()->click();
		} elseif (strcmp($action, 'submit') == 0) {
			// Select Payment Method
			if (isset($paymentMethod)) {
				$count = 1;
				foreach ($paymentMethod as $method) {
					if ($count > 1) {
						$this->webposIndex->getOrdersHistory()->getTakePaymentAddMorePaymentButton()->click();
						self::assertTrue(
							$this->webposIndex->getOrdersHistory()->getTakePaymentMorePaymentContainer()->isVisible(),
							"More Payment List is not displayed"
						);
						self::assertTrue(
							$this->webposIndex->getOrdersHistory()->getTakePaymentMorePaymentItem($method['name'])->isVisible(),
							"Can find payment method '".$method['name']."' in list"
						);
						$this->webposIndex->getOrdersHistory()->getTakePaymentMorePaymentItem($method['name'])->click();
					} else {
						self::assertTrue(
							$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($method['name'])->isVisible(),
							"Can't find payment method '".$method['name']."' in list"
						);
						$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentItem($method['name'])->click();
					}
					if (isset($method['amount']) ) {
						sleep(1);
						$this->webposIndex->getOrdersHistory()->getTakePaymentPaymentInputBox($method['name'])->setValue($method['amount']);
						$result['total-paid'] += $method['amount'];
						$result['remain-money'] = (float)$result['remain-money'] - (float)$method['amount'];
					}
					$count++;
				}
			}

			$this->webposIndex->getOrdersHistory()->getTakePaymentSubmitButton()->click();


			// Assert Confirmation Popup
			$this->assertTakePaymentConfirmPopupDisplay->processAssert($this->webposIndex);

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
			'paymentMethod' => $paymentMethod
		];
	}
}