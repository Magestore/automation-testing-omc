<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 10:51
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertTakePaymentConfirmPopupDisplay extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCloseButton()->isVisible(),
			'Take Payment Confirm popup - Close is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getCancelButton()->isVisible(),
			'Take Payment Confirm popup - Cancel is not displayed'
		);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getModal()->getOkButton()->isVisible(),
			'Take Payment Confirm popup - OK is not displayed'
		);

		\PHPUnit_Framework_Assert::assertEquals(
			'Are you sure you want to take payment on this order?',
			$webposIndex->getModal()->getPopupMessage(),
			'Take Payment Confirm popup - Message content is wrong'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Take Payment - Confirm Popup Display: Pass";
	}
}