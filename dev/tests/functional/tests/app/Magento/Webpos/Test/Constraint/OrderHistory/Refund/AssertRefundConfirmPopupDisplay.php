<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 20/10/2017
 * Time: 09:04
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Refund;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertRefundConfirmPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCloseButton()->isVisible(),
			'Refund Confirm popup - Close is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCancelButton()->isVisible(),
			'Refund Confirm popup - Cancel is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getOkButton()->isVisible(),
			'Refund Confirm popup - OK is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Are you sure you want to refund this order?',
			$webposIndex->getModal()->getPopupMessage(),
			'Refund Confirm popup - Message content is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Refund - Confirm Popup Display: Pass";
	}
}