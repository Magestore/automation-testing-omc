<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 13:23
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;

/**
 * Class AssertOrderStatusInBackend
 * @package Magento\Webpos\Test\Constraint\SectionOrderHistory
 */
class AssertOrderStatusInBackend extends AbstractConstraint
{
	/**
	 * @param OrderIndex $orderIndex
	 * @param SalesOrderView $salesOrderView
	 * @param $orderId
	 * @param $expectStatus
	 */
	public function processAssert(
		OrderIndex $orderIndex,
		SalesOrderView $salesOrderView,
		$orderId,
		$expectStatus
	)
	{
		$orderIndex->open();

		$orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $orderId]);
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
		return "Order status in backend is correct";
	}
}