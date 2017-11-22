<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/10/2017
 * Time: 17:07
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;

class AssertCancelOrderInBackend extends AbstractConstraint
{
	public function processAssert(
		OrderIndex $orderIndex,
		SalesOrderView $salesOrderView,
		$orderId
	)
	{
		$orderIndex->open();

		\PHPUnit_Framework_Assert::assertTrue(
			$orderIndex->getSalesOrderGrid()->isRowVisible(['id' => $orderId], true, false),
			"Order is absent in Grid"
		);

		$orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $orderId]);
		\PHPUnit_Framework_Assert::assertEquals(
			'Canceled',
			$salesOrderView->getOrderInfoBlock()->getOrderStatus(),
			'Order status is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Order Cancelled in Backend: Pass";
	}
}