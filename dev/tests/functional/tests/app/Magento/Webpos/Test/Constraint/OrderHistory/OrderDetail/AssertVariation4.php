<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/10/2017
 * Time: 11:27
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\OrderDetail;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertVariation4 extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param $actions
	 * @param $result
	 */
	public function processAssert(WebposIndex $webposIndex, $actions, $result)
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

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getMoreInfoButton()->isVisible(),
			'Order History - More Info Icon is not displayed'
		);

		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getActionsBox()->isVisible(),
			'Actions box is not displayed'
		);
		$actionsList = explode(',', $actions );
		foreach ($actionsList as $action) {
			\PHPUnit_Framework_Assert::assertTrue(
				$webposIndex->getOrdersHistory()->getAction($action)->isVisible(),
				"Action '".$action."' is not showed"
			);
		}

	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Display Actions Box: Pass";
	}
}