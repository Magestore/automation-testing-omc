<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/10/2017
 * Time: 10:22
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertDataRefundInvalidMessage extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->getWarningMessage()->isVisible(),
			'Order History - Refund - Qty = 0 - Error Message is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Data Refund Invalid!',
			$webposIndex->getToaster()->getWarningMessage()->getText(),
			'Message content is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Qty = 0 - display error message: Pass";
	}
}