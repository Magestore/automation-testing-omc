<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/01/2018
 * Time: 10:16
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertPaymentMethodsAreShownCorrectlyOnOrderDetail
 * @package Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod
 */
class AssertPaymentMethodsAreShownCorrectlyOnOrderDetail extends AbstractConstraint
{
	/**
	 * @param WebposIndex $webposIndex
	 * @param \Magento\Webpos\Test\Constraint\OrderHistory\PaymentShippingMethod\AssertPaymentMethodIsShownOnDetailOrder $assertPaymentMethodIsShownOnDetailOrder
	 * @param $paymentMethods
	 */
	public function processAssert(
		WebposIndex $webposIndex,
		AssertPaymentMethodIsShownOnDetailOrder $assertPaymentMethodIsShownOnDetailOrder,
		$paymentMethods
	)
	{
		foreach ($paymentMethods as $method) {
			$assertPaymentMethodIsShownOnDetailOrder->processAssert($webposIndex, $method['label'], $method['amount']);
		}
	}

	/**
	 * Returns a string representation of the object.
	 *
	 * @return string
	 */
	public function toString()
	{
		return "Orders History - Payment methods are shown correctly on order detail";
	}
}