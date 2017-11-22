<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/10/2017
 * Time: 15:45
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertInvoiceConfirmPopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getModal()->getModalPopup()->isVisible(),
			'Confirm Popup is not closed'
		);

		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getInvoicePopup()->isVisible(),
			'Invoice Popup is not displayed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Invoice Popup - Close Confirm Popup: Pass";
	}
}