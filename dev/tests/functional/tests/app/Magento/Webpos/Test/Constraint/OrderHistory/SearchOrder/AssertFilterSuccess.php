<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/10/2017
 * Time: 11:11
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\SearchOrder;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertFilterSuccess extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $status)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			'Order History - Search Order - Filter by status - Order list is empty'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$status,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Order History - Search Order - Filter by status - Order Status is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Search Order - Filter by status : Success";
	}
}