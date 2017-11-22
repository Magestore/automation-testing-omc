<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/10/2017
 * Time: 17:19
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderDetail;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation3 extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $expectedStatus
	 * @param $result
	 */
	public function processAssert(WebposIndex $webposIndex, $expectedStatus,$amount, $remain, $result)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			$remain,
			$result['remain-money'],
			'Change is not updated on place order page'
		);
		$webposIndex->getMsWebpos()->clickCMenuButton();
		$webposIndex->getCMenu()->ordersHistory();
		sleep(2);
		$webposIndex->getOrdersHistory()->getFirstOrder()->click();

		while (strcmp($webposIndex->getOrdersHistory()->getStatus(), 'Not Sync') == 0) {}
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getFirstOrder()->isVisible(),
			"Order List is empty"
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$result['orderId'],
			$webposIndex->getOrdersHistory()->getOrderId(),
			'Created Order is not displayed on top of order list'
		);
		$price = $webposIndex->getOrdersHistory()->getPrice();
		$price = substr($price, 1);
		\PHPUnit_Framework_Assert::assertEquals(
			$result['total'],
			$price,
			'Order Total is wrong'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float) $amount,
			(float) $webposIndex->getOrdersHistory()->getTotalPaid(),
			'Order Total Paid is wrong'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			(float) $remain,
			(float) $webposIndex->getOrdersHistory()->getChange(),
			'Order Change on Order Detail is wrong'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			$expectedStatus,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Order Status is Wrong'
		);


		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getPrintButton()->isVisible(),
			'Print Button is not displayed'
		);

	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Variation 3: Pass";
	}
}