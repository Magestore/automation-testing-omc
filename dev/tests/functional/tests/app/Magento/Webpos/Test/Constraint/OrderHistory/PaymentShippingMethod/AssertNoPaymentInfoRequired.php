<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/01/2018
 * Time: 10:44
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertNoPaymentInfoRequired extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex)
	{
		\PHPUnit_Framework_Assert::assertEquals(
			'No Payment Information Required',
			$webposIndex->getOrderHistoryOrderViewContent()->getPaymentMethodContent()->getText(),
			'message "No Payment Information Required" was not shown on Payment method section'
		);

	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Orders History - Payment/Shipping method - Showed message \"No Payment Information Required\" on Payment method section";
	}
}