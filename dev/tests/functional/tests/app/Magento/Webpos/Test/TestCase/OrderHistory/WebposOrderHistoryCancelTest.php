<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 15:31
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelOrderConfimationPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Shipment\AssertShipmentCreateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryCancelTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertCancelPopupDisplay
	 */
	protected $assertCancelPopupDisplay;

	/**
	 * @var AssertCancelOrderConfimationPopupDisplay
	 */
	protected $assertCancelOrderConfimationPopupDisplay;

	/**
	 * @var AssertShipmentCreateSuccess
	 */
	protected $assertShipmentCreateSuccess;


	public function __inject(
		WebposIndex $webposIndex,
		AssertShipmentCreateSuccess $assertShipmentCreateSuccess,
		AssertCancelPopupDisplay $assertCancelPopupDisplay,
		AssertCancelOrderConfimationPopupDisplay $assertCancelOrderConfimationPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertShipmentCreateSuccess = $assertShipmentCreateSuccess;
		$this->assertCancelPopupDisplay = $assertCancelPopupDisplay;
		$this->assertCancelOrderConfimationPopupDisplay = $assertCancelOrderConfimationPopupDisplay;
	}

	public function test(
		Staff $staff,
		$products,
		$shipped = false,
		$paid = true,
		$createShipment = false,
		$comment = null,
		$action = 'save',
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
			$this->webposIndex->getCheckoutPage()->search($product['sku']);
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

		// Create Shipment
		if ($createShipment) {
			$shipText = 'Ship';
			$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
			self::assertTrue(
				$this->webposIndex->getOrdersHistory()->getAction($shipText)->isVisible(),
				'Order History - Cancel Order - Ship Action is missed'
			);

			$this->webposIndex->getOrdersHistory()->getAction($shipText)->click();

			$this->webposIndex->getOrdersHistory()->getShipSummitButton()->click();
			$this->webposIndex->getModal()->getOkButton()->click();
			$this->assertShipmentCreateSuccess->processAssert($this->webposIndex, 'Processing', false);
		}
		//////////////////

		$cancelText = "Cancel";
		if (!$this->webposIndex->getOrdersHistory()->getActionsBox()->isVisible()) {
			$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		}
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getAction($cancelText)->isVisible(),
			'Order History - Cancel Order - Cancel Action is missed'
		);

		$this->webposIndex->getOrdersHistory()->getAction($cancelText)->click();
		// Assert Cancel Popup Display
		$this->assertCancelPopupDisplay->processAssert($this->webposIndex);

		if (strcmp($action, 'cancel') == 0) {
			$this->webposIndex->getOrdersHistory()->getCancelOrderCancelButton()->click();
		} elseif (strcmp($action, 'save') == 0) {
			if (!empty($comment)) {
				$comment = str_replace('%isolation%', rand(1, 9999999), $comment);
				$this->webposIndex->getOrdersHistory()->getCancelOrderCommentInput()->setValue($comment);
			}

			$this->webposIndex->getOrdersHistory()->getCancelOrderSaveButton()->click();

			// Assert Confirmation Popup
			$this->assertCancelOrderConfimationPopupDisplay->processAssert($this->webposIndex);

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
			'expectStatus' => $expectStatus
		];
	}
}