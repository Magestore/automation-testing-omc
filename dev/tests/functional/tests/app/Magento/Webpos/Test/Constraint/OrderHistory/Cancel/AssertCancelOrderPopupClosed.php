<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 29/01/2018
 * Time: 10:31
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCancelOrderPopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrderHistoryAddCancelComment()->isVisible(),
			'Cancel Order Popup is not closed'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Cancel Order - Popup close: Success";
	}
}