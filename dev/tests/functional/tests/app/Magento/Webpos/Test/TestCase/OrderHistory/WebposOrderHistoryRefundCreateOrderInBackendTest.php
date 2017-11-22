<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 16:27
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderInvoiceNew;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
use Magento\Webpos\Test\Constraint\OrderHistory\Refund\AssertRefundPopupDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryRefundCreateOrderInBackendTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var OrderInvoiceNew
	 */
	protected $orderInvoiceNew;

	/**
	 * @var SalesOrderView
	 */
	protected $salesOrderView;

	/**
	 * @var AssertRefundPopupDisplay
	 */
	protected $assertRefundPopupDisplay;

	/**
	 * @var OrderInjectable
	 */
	protected $order;

	public function __inject(
		WebposIndex $webposIndex,
		OrderInvoiceNew $orderInvoiceNew,
		SalesOrderView $salesOrderView,
		AssertRefundPopupDisplay $assertRefundPopupDisplay
	)
	{
		$this->webposIndex = $webposIndex;
		$this->orderInvoiceNew = $orderInvoiceNew;
		$this->salesOrderView = $salesOrderView;
		$this->assertRefundPopupDisplay = $assertRefundPopupDisplay;
	}

	public function test(
		OrderInjectable $order,
		Staff $staff,
		$hideAction = null,
		$expectStatus = null,
		$totalRefunded = null
	)
	{
		$this->order = $order;
		$this->order->persist();

		//Create Invoice
		$this->orderInvoiceNew->open(['order_id' => (int)$this->order->getId()]);
		$this->orderInvoiceNew->getFormBlock()->submit();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
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

		$refundText = 'Refund';
		$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getAction($refundText)->isVisible(),
			'Order History - Refund - Refund Action is missed'
		);
		$this->webposIndex->getOrdersHistory()->getAction($refundText)->click();

		$productList = $this->order->getEntityId()['products'];

		foreach ($productList as $product) {
			$products[] = [
				'name' => $product->getName(),
				'qty' => $product->getCheckoutData()['qty']
			];
		}

		// Assert Refund Popup display
		$this->assertRefundPopupDisplay->processAssert($this->webposIndex, $products);

		sleep(1);

		$this->webposIndex->getOrdersHistory()->getRefundSubmitButton()->click();
		$this->webposIndex->getModal()->getOkButton()->click();

		return [
			'orderId' => $order->getId(),
			'expectStatus' => $expectStatus,
			'hideAction' => $hideAction,
			'totalRefunded' => $totalRefunded
		];
	}
}