<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 10:17
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryShipmentCreateOrderInBackendTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var OrderInjectable
	 */
	protected $order;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		OrderInjectable $order,
		Staff $staff,
		$statusAfterShip = null,
		$shipPartial = false
	)
	{
		$this->order = $order;
		$this->order->persist();

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

		self::assertEquals(
			$this->order->getId(),
			$this->webposIndex->getOrdersHistory()->getOrderId(),
			'Order Id is wrong'
		);

		$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		$this->webposIndex->getOrdersHistory()->getAction('Ship')->click();

		$this->webposIndex->getOrdersHistory()->getShipSummitButton()->click();
		$this->webposIndex->getModal()->getOkButton()->click();

		$productList = $this->order->getEntityId()['products'];

		foreach ($productList as $product) {
			$products[] = [
				'name' => $product->getName(),
				'qty' => $product->getCheckoutData()['qty'],
				'ship_qty' => $product->getCheckoutData()['qty']
			];
		}

		return [
			'products' => $products,
			'orderId' => $this->order->getId(),
			'statusAfterShip' => $statusAfterShip,
			'shipPartial' => $shipPartial
		];
	}
}