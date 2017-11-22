<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 05/10/2017
 * Time: 10:15
 */

namespace Magento\Webpos\Test\TestCase\OrderHistory;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOrderHistoryReOrderTest extends Injectable
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
		$products
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
		$this->webposIndex->getCheckoutPage()->clickPlaceOrder();
		sleep(1);
		$this->webposIndex->getCheckoutPage()->clickNewOrderButton();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->ordersHistory();

		sleep(2);
		$this->webposIndex->getOrdersHistory()->getFirstOrder()->click();

		while (strcmp($this->webposIndex->getOrdersHistory()->getStatus(), 'Not Sync') == 0) {}
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			"Order List is empty"
		);
		$reOrderText = 'Re-order';
		$this->webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		self::assertTrue(
			$this->webposIndex->getOrdersHistory()->getAction($reOrderText)->isVisible(),
			'Order History - Re-Order - Add Comment Action is missed'
		);

		$this->webposIndex->getOrdersHistory()->getAction($reOrderText)->click();
		return ['products' => $products];
	}

}