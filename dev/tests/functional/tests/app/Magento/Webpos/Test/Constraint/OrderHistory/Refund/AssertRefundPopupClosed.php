<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/10/2017
 * Time: 09:07
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundPopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getRefundPopup()->isVisible(),
			'Refund Popup is not closed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Close Refund Popup: Pass";
	}
}