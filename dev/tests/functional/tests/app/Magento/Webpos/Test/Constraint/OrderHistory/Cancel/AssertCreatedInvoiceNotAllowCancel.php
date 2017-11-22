<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/10/2017
 * Time: 14:24
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Cancel;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCreatedInvoiceNotAllowCancel extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(10);
		$webposIndex->getOrdersHistory()->getMoreInfoButton()->click();
		\PHPUnit_Framework_Assert::assertFalse(
			$webposIndex->getOrdersHistory()->getAction('Cancel')->isVisible(),
			'Cancel Action is not hided'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Cancel Order (created invoice) - Not allow to cancel: Pass";
	}
}