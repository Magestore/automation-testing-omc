<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 12/10/2017
 * Time: 11:13
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelOrderConfimationPopupDisplay;
use Magento\Webpos\Test\Constraint\OrderHistory\Cancel\AssertCancelPopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryCancelOrderCreateInBackendTest extends Injectable
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
	 * @var OrderInjectable
	 */
	protected $order;

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
		OrderInjectable $order,
		Staff $staff,
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
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

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
			'orderId' => $order->getId(),
			'expectStatus' => $expectStatus
		];
	}
}