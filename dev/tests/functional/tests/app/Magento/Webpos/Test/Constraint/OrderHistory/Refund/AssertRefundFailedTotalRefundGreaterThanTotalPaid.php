<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 10:45
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundFailedTotalRefundGreaterThanTotalPaid extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Error Popup is not shown'
		);

		\PHPUnit_Framework_Assert::assertContains(
			'The refundable amount is limited at',
			$webposIndex->getModal()->getPopupMessage(),
			'Popup message is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Adjust Refund > Adjust Fee - Error Popup is displayed";
	}
}