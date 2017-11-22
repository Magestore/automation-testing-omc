<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/10/2017
 * Time: 14:19
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentConfirmPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentPopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryShipmentTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertShipmentPopupDisplay
	 */
	protected $assertShipmentPopupDisplay;

	/**
	 * @var AssertShipmentConfirmPopupDisplay
	 */
	protected $assertShipmentConfirmPopupDisplay;

	public function __inject(
		WebposIndex $webposIndex,
		AssertShipmentPopupDisplay $assertShipmentPopupDisplay,
		AssertShipmentConfirmPopupDisplay $assertShipmentConfirmPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertShipmentPopupDisplay = $assertShipmentPopupDisplay;
		$this->assertShipmentConfirmPopupDisplay = $assertShipmentConfirmPopupDisplay;
	}

	public function test(
		Staff $staff,
		$products,
		$shipped = false,
		$paid = true,
		$comment = null,
		$trackNumber = null,
		$sendEmail = false,
		$shipPartial = false,
		$submit = true,
		$confirmAction = null,
		$statusAfterShip = null
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
		$shipText = 'Ship';
		$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getAction($shipText)->isVisible(),
			'Order History - Shipment - Ship Action is missed'
		);

		$this->webposIndex->getOrdersHistory()->getAction($shipText)->click();

		// Assert Shipment Popup Display
		$this->assertShipmentPopupDisplay->processAssert($this->webposIndex, $products);

		foreach ($products as $product) {
			$this->webposIndex->getOrdersHistory()->getShipItemQtyInputBox($product['name'])->setValue($product['ship_qty']);
		}

		if (!empty($comment)) {
			$comment = str_replace('%isolation%', rand(1, 9999999), $comment);
			$this->webposIndex->getOrdersHistory()->getShipCommentBox()->setValue($comment);
		}

		if (!empty($trackNumber)) {
			$trackNumber = str_replace('%isolation%', rand(1, 9999999), $trackNumber);
			$this->webposIndex->getOrdersHistory()->getShipTrackNumberBox()->setValue($trackNumber);
		}

		if ($this->webposIndex->getOrdersHistory()->getShipSendEmailCheckbox()->isSelected() != $sendEmail) {
			$this->webposIndex->getOrdersHistory()->getShipSendEmailCheckbox()->click();
		}

		if ($submit) {
			$this->webposIndex->getOrdersHistory()->getShipSummitButton()->click();
			$this->assertShipmentConfirmPopupDisplay->processAssert($this->webposIndex);
			if (strcmp($confirmAction, 'close') == 0) {
				$this->webposIndex->getModal()->getCloseButton()->click();
			} elseif (strcmp($confirmAction, 'cancel') == 0) {
				$this->webposIndex->getModal()->getCancelButton()->click();
			} elseif (strcmp($confirmAction, 'ok') == 0) {
				$this->webposIndex->getModal()->getOkButton()->click();
			}
		} else {
			$this->webposIndex->getOrdersHistory()->getShipCancelButton()->click();
		}


		return [
			'products' => $products,
			'orderId' => $orderId,
			'shipPartial' => $shipPartial,
			'statusAfterShip' => $statusAfterShip
		];
	}
}