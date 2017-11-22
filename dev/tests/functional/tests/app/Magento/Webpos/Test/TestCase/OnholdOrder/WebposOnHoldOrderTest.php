<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/09/2017
 * Time: 13:33
 */

namespace Magento\Webpos\Test\TestCase\OnholdOrder;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposOnHoldOrderTest extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff, $products, $action)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()){
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}
		foreach ($products as $item) {
			$this->webposIndex->getCheckoutPage()->search($item);
		}
		$orderInfo['subtotal'] = $this->webposIndex->getCheckoutPage()->getSubTotal();
		$orderInfo['total'] = $this->webposIndex->getCheckoutPage()->getTotal2();
		$this->webposIndex->getCheckoutPage()->clickHoldButton();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->onHoldOrders();
		$this->webposIndex->getOnHoldOrder()->getFirstOrder()->click();
		$onHoldOrder['order_id'] = $this->webposIndex->getOnHoldOrder()->getOrderId();
		$onHoldOrder['subtotal'] = $this->webposIndex->getOnHoldOrder()->getSubTotal();
		$onHoldOrder['total'] = $this->webposIndex->getOnHoldOrder()->getTotal();
		self::assertEquals(
			$orderInfo['subtotal'],
			$onHoldOrder['subtotal'],
			'subtotal is wrong'
		);
		self::assertEquals(
			$orderInfo['total'],
			$onHoldOrder['total'],
			'total is wrong'
		);
		if (strcmp($action, 'delete') == 0) {
			sleep(3);
			$this->webposIndex->getOnHoldOrder()->getDeleteButton()->click();
			sleep(1);
			if ($this->webposIndex->getOnHoldOrder()->getFirstOrder()->isVisible()) {
				self::assertNotEquals(
					$onHoldOrder['order_id'],
					$this->webposIndex->getOnHoldOrder()->getOrderId(),
					"order details block don't display next order"
				);
			}
		} elseif (strcmp($action, 'checkout') == 0) {
			$this->webposIndex->getOnHoldOrder()->getCheckoutButton()->click();
			self::assertNotFalse(
				$this->webposIndex->getCheckoutPage()->isVisible(),
				'Not redirect to checkout page'
			);
			self::assertEquals(
				$onHoldOrder['subtotal'],
				$this->webposIndex->getCheckoutPage()->getSubTotal(),
				'checkout subtotal is wrong'
			);
			self::assertEquals(
				$onHoldOrder['total'],
				$this->webposIndex->getCheckoutPage()->getTotal2(),
				'checkout total is wrong'
			);
			$this->webposIndex->getCheckoutPage()->selectPayment();
			$this->webposIndex->getCheckoutPage()->clickPlaceOrder();
			self::assertEquals(
				'Order has been created successfully',
				$this->webposIndex->getCheckoutPage()->getNotifyOrderText(),
				'order place failed.'
			);
			$this->webposIndex->getCheckoutPage()->clickNewOrderButton();
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->onHoldOrders();
			if ($this->webposIndex->getOnHoldOrder()->getFirstOrder()->isVisible()) {
				self::assertNotEquals(
					$onHoldOrder['order_id'],
					$this->webposIndex->getOnHoldOrder()->getOrderId(),
					"on hold page don't display next order detail"
				);
			}
		}


	}
}