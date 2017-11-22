<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 15:51
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundActionIsHidden extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		sleep(1);
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Refund')->isVisible(),
			'Order History - Refund - Refund action is not hidden'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Add discount 100% - Refund Action is hidden: Pass";
	}
}