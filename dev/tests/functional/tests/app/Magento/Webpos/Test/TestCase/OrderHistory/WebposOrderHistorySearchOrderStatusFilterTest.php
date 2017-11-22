<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/10/2017
 * Time: 10:30
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistorySearchOrderStatusFilterTest extends Injectable
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
		$status = 'Pending'
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

		$this->webposIndex->getCheckoutPage()->clickFirstProduct();
		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$this->webposIndex->getCheckoutPage()->selectPayment();
		sleep(1);

		$shippingCheckbox = $this->webposIndex->getCheckoutPage()->getShippingCheckbox();
		$shipped = false;
		if ($shippingCheckbox->isVisible()) {
			if ($shipped != $this->webposIndex->getCheckoutPage()->isCheckboxChecked($shippingCheckbox)) {
				$shippingCheckbox->click();
			}
		}

		$paidCheckbox = $this->webposIndex->getCheckoutPage()->getPaidCheckbox();
		$paid = false;
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

		// Change Order Status
		$this->webposIndex->getOrdersHistory()->search($orderId);
		sleep(1);


		if (strcmp($status, "Pending") != 0) {
			if (strcmp($status, 'Cancelled') == 0) {
				$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
				$this->webposIndex->getOrdersHistory()->getAction('Cancel')->click();
				$this->webposIndex->getOrdersHistory()->getCancelOrderSaveButton()->click();
				$this->webposIndex->getModal()->getOkButton()->click();
				sleep(7);
			} else {
				// Processing
				$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
				$this->webposIndex->getOrdersHistory()->getAction('Ship')->click();
				$this->webposIndex->getOrdersHistory()->getShipSummitButton()->click();
				$this->webposIndex->getModal()->getOkButton()->click();
				sleep(7);
				// Complete
				if (strcmp($status, 'Complete') == 0 || strcmp($status, 'Closed') == 0) {
					$this->webposIndex->getOrdersHistory()->getInvoiceButton()->click();
					$this->webposIndex->getOrdersHistory()->getInvoiceSubmitButton()->click();
					$this->webposIndex->getModal()->getOkButton()->click();
					sleep(7);
				}

				// Closed
				if (strcmp($status, 'Closed') == 0) {
					$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
					$this->webposIndex->getOrdersHistory()->getAction('Refund')->click();
					$this->webposIndex->getOrdersHistory()->getRefundSubmitButton()->click();
					$this->webposIndex->getModal()->getOkButton()->click();
					sleep(7);
				}
			}
		}
		////////////////////////

		$this->webposIndex->getOrdersHistory()->search('');
		sleep(1);
		// Filter
		$this->webposIndex->getOrdersHistory()->getFilterStatusButton($status)->click();
		sleep(1);

		return ['status' => $status];
	}
}