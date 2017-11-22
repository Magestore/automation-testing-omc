<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/10/2017
 * Time: 14:49
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertAllowToRefundExtandItems extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		if (!$webposIndex->getOrdersHistory()->getActionsBox()->isVisible()) {
			$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		}
		sleep(1);
		$text = 'Refund';
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getAction($text)->isVisible(),
			'Refund Action is not shown'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Allow to Refund Extand Items: Pass";
	}
}