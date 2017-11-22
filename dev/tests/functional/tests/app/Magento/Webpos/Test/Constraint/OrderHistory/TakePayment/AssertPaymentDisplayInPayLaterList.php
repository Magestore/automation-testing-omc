<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 16/10/2017
 * Time: 16:29
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\TakePayment;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertPaymentDisplayInPayLaterList extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $paymentMethod)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrdersHistory()->getPayLaterPayment($paymentMethod[0]['name'])->isVisible(),
			'Payment selected : ('.$paymentMethod[0]['name'].') is not shown in Pay Later List'
		);
	}
	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Order History - Take Payment - Payment display in Pay Later List: Pass";
	}
}