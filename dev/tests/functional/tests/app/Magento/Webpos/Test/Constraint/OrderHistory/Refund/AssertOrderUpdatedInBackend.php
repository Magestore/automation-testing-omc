<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 17:24
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;

class AssertOrderUpdatedInBackend extends AbstractConstraint
{
	public function processAssert(SalesOrderView $salesOrderView, $orderId, $expectStatus)
	{
		$salesOrderView->open(['order_id' => (int)$orderId]);
		\PHPUnit_Framework_Assert::assertEquals(
			$expectStatus,
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
		return "Order History - Refund - Order updated in backend";
	}
}