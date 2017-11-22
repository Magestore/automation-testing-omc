<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 12/10/2017
 * Time: 10:42
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelOrderConfimationPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelPopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryCancelOrderCustomProductTest extends Injectable
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

	public function __inject(
		WebposIndex $webposIndex,
		AssertCancelPopupDisplay $assertCancelPopupDisplay,
		AssertCancelOrderConfimationPopupDisplay $assertCancelOrderConfimationPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertCancelPopupDisplay = $assertCancelPopupDisplay;
		$this->assertCancelOrderConfimationPopupDisplay = $assertCancelOrderConfimationPopupDisplay;
	}

	public function test(
		Staff $staff,
		$product,
		$shipped = false,
		$paid = true,
		$expectStatus = null
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

		$this->webposIndex->getCheckoutPage()->getCustomSaleButton()->click();

		self::assertTrue(
			$this->webposIndex->getCheckoutPage()->getPopupCustomSale()->isVisible(),
			'Custom Sale Popup is not showed'
		);

		$product['name'] = str_replace('%isolation%', rand(1, 9999999), $product['name']);
		$this->webposIndex->getCheckoutPage()->getCustomSaleProductNameInput()->setValue($product['name']);
		$this->webposIndex->getCheckoutPage()->getCustomSaleProductPriceInput()->setValue($product['price']);

		$this->webposIndex->getCheckoutPage()->getCustomSaleAddToCartButton()->click();

		$this->webposIndex->getCheckoutPage()->clickCheckoutButton();
		sleep(1);
		$this->webposIndex->getCheckoutPage()->selectPayment();
		sleep(1);
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

		$this->webposIndex->getOrdersHistory()->getCancelOrderSaveButton()->click();

		// Assert Confirmation Popup
		$this->assertCancelOrderConfimationPopupDisplay->processAssert($this->webposIndex);

		$this->webposIndex->getModal()->getOkButton()->click();

		return [
			'orderId' => $orderId,
			'expectStatus' => $expectStatus
		];
	}
}