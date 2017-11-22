<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/10/2017
 * Time: 07:45
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistorySearchOrderTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	public function __prepare(
		OrderInjectable $order
	)
	{
		$order->persist();
		return ['order' => $order];
	}

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		OrderInjectable $order
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

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();

		sleep(1);

		// Search incorrect order
		$this->webposIndex->getOrdersHistory()->search('adnaknfkanfueiefiaei');
		sleep(1);

		self::assertFalse(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			'Order History - Search - Incorrect Order ID - Order list is not empty'
		);

		self::assertFalse(
			$this->webposIndex->getOrdersHistory()->getOrderViewContainer()->isVisible(),
			'Order History - Search - Incorrect Order ID - Order Detail is not empty'
		);

		// Search correct Order
		$this->webposIndex->getOrdersHistory()->search($order->getId());
		sleep(1);

		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			'Order History - Search - Correct Order ID - Order list is empty'
		);

		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getOrderViewContainer()->isVisible(),
			'Order History - Search - Correct Order ID - Order Detail is empty'
		);

		self::assertEquals(
			$order->getId(),
			$this->webposIndex->getOrdersHistory()->getOrderId(),
			'Order History - Search - Correct Order ID - Order Id on order detail is wrong'
		);

		// Delete Keyword

		$this->webposIndex->getOrdersHistory()->search('');
		sleep(1);

		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getSecondOrder()->isVisible(),
			'Order History - Search - Blank - all Order is not shown on order list'
		);
	}
}