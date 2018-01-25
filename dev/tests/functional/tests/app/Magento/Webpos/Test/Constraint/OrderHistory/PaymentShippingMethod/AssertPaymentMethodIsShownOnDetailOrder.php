<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 08:54
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertPaymentMethodIsShownOnDetailOrder extends AbstractConstraint
{
	public function processAssert(WebposIndex $webposIndex, $paymentLabel, $paymentAmount)
	{
		\PHPUnit_Framework_Assert::assertTrue(
			$webposIndex->getOrderHistoryOrderViewContent()->getPaymentMethod($paymentLabel)->isVisible(),
			'Orders History - Payment method "'.$paymentLabel.'" is not shown on order detail'
		);
		$amountOnPage = $webposIndex->getOrderHistoryOrderViewContent()->getPaymentMethodAmount($paymentLabel)->getText();
		$amountOnPage = (float) substr($amountOnPage,1);
		\PHPUnit_Framework_Assert::assertEquals(
			$paymentAmount,
			$amountOnPage,
			'Orders History - Payment method "'.$paymentLabel.'" - Amount is wrong'
		);
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return 'Orders History - Payment method is shown on order detail';
	}
}