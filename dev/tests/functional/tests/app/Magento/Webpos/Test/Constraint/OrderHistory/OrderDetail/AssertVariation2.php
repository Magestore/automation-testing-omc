<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/10/2017
 * Time: 16:48
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderDetail;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation2 extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $expectedStatus, $result)
	{
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
			$expectedStatus,
			$webposIndex->getOrdersHistory()->getStatus(),
			'Order Status is Wrong'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getPrintButton()->isVisible(),
			'Print Button is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoiceButton()->isVisible(),
			'Invoice Button is not displayed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getTakePaymentButton()->isVisible(),
			'Take Payment Button is not displayed'
		);

	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Variation 2: Pass";
	}
}