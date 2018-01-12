<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 19/10/2017
 * Time: 16:49
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertNotAllowToCreateInvoice extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		sleep(1);
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getToaster()->isVisible(),
			'Warning message is not shown'
		);
		\PHPUnit_Framework_Assert::assertEquals(
			'You must take payment on this order before creating invoice',
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
		return "Order History - Invoice -(Invoice without Take Payment) Not Allow to create Invoice : Pass";
	}
}