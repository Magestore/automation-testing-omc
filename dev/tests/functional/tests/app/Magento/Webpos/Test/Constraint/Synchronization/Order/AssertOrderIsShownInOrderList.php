<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 13:34
 */

namespace Magento\Webpos\Test\Constraint\Synchronization\Order;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertOrderIsShownInOrderList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $orderId, $status, $action = '')
	{
		$webposIndex->open();
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->ordersHistory();
		sleep(1);
		$webposIndex->getOrdersHistory()->search($orderId);
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			'Synchronization - Order - '.$action.' -'.$orderId.' is not shown in list'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$orderId,
			$webposIndex->getOrdersHistory()->getOrderId(),
			'Synchronization - Order - '.$action.' - Order ID is wrong'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			$status,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Synchronization - Order - '.$action.' - Order Status is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Synchronization - Order - Order is shown correctly in Order list";
	}
}