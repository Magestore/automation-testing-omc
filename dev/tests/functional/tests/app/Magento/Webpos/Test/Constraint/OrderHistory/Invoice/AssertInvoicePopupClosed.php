<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 18/10/2017
 * Time: 15:38
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertInvoicePopupClosed extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getInvoicePopup()->isVisible(),
			'Invoice Popup is not closed'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Invoice - Close Invoice Popup: Pass";
	}
}