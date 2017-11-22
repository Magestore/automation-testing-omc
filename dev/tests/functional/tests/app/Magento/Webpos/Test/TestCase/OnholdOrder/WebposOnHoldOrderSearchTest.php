<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/09/2017
 * Time: 16:12
 */

namespace Magento\Webpos\Test\TestCase\OnholdOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOnHoldOrderSearchTest extends Injectable
{
    protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff, $products)
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
		foreach ($products as $item) {
			$this->webposIndex->getCheckoutPage()->search($item);
			$this->webposIndex->getCheckoutPage()->clickHoldButton();
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->onHoldOrders();
			$orderIds[] = $this->webposIndex->getOnHoldOrder()->getOrderId();
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->checkout();
		}
		sleep(1);

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->onHoldOrders();
		// test case search order 1
		$this->webposIndex->getOnHoldOrder()->search('abjfbkjasdbabfjafadksf');
		sleep(1);
		self::assertFalse(
			$this->webposIndex->getOnHoldOrder()->getFirstOrder()->isVisible(),
			'on hold order - search 1 - order list not empty'
		);
		// test case search order 2
		$this->webposIndex->getOnHoldOrder()->search($orderIds[0]);
		sleep(1);
		self::assertNotFalse(
			$this->webposIndex->getOnHoldOrder()->getFirstOrder()->isVisible(),
			'on hold order - search 2 - order not displayed'
		);
		self::assertEquals(
			$orderIds[0],
			$this->webposIndex->getOnHoldOrder()->getOrderId(),
			'on hold order - search 2 - found order is wrong'
		);
		// test case search order 3
		$this->webposIndex->getOnHoldOrder()->search('abjfbkjasdbabfjafadksf');
		sleep(1);
		self::assertFalse(
			$this->webposIndex->getOnHoldOrder()->getFirstOrder()->isVisible(),
			'on hold order - search 3 - order list not empty'
		);
		$this->webposIndex->getOnHoldOrder()->search('');
		sleep(1);
		self::assertNotFalse(
			$this->webposIndex->getOnHoldOrder()->getFirstOrder()->isVisible(),
			"on hold order - search 3 - order list don't display all order"
		);
	}
}